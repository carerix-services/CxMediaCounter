<?php
class CxVisit {
	/**
	 * Holds the current visit
	 * @var DbVisit
	 */
	protected $_currVisit = null;
	
	/**
	 * Holder for various responses. This allows the script to gather certain info
	 * in one go, instead of having to, in essence, redo a previous call just to
	 * obtain a different field of the same object.
	 *  
	 * @var array()
	 */
	protected $_responseCache = array();
	
	/**
	 * Returns the type of class that will be passed to the visit.
	 */
	protected function _getType() {
		return __CLASS__;
	} // getType();
	
	/**
	 * Handles a visit that is not long enough
	 */
	public function incomplete() {
		$error = new CxError();
		return $error->incomplete(__CLASS__);
	} // incomplete();
	
	/**
	 * Handles a visit that is too long
	 */
	public function overcomplete() {
		$error = new CxError();
		return $error->incomplete(__CLASS__);
	} // overcomplete();
	
	/**
	 * Handles a visit registration followed by a redirect.
	 * The theoretical path is /visitType/:appname/:customername/:campaignname/:vacancyID/:employeeID/:emailID/:employeeChecksum/**  
	 */
	public function redirect() {
		// obtain the uriparts that are needed
		$uriparts = (object) params();
		$uriparts->redirect = empty($_REQUEST['url']) ? null: $_REQUEST['url'];
		$uriparts->type = $this->_getType();
		
		// create a new DbVisit entity
		$this->_currVisit = new DbVisit();
		$nextIs = false;
		foreach ( $uriparts as $uripart => $value ) {
			if ( !empty($nextIs) ) {
				$this->_currVisit->$nextIs = $value;
				$nextIs = false;
			} else if ( stripos($uripart, 'nextIs') === 0 ) {
				$nextIs = $value;
			} else {
				$this->_currVisit->$uripart = $value;
			}
		} // foreach
		$this->_currVisit->env = 
					"IP:    {$_SERVER['REMOTE_ADDR']}" . PHP_EOL
				. "Query: {$_SERVER['QUERY_STRING']}" . PHP_EOL
				. "Date:  " . strftime('%Y-%m-%dT%H:%M:%S%z')
		;
		
		// usefull exception for testing
// 		throw new Exception('Disable line ' . __LINE__ . ' of file ' . __FILE__ . ' to store the visit');
		
		// store the visit in DB
		$this->_currVisit->store();

		// usefull exception for testing
// 		throw new Exception('Disable line ' . __LINE__ . ' of file ' . __FILE__ . ' to touch the queue');
		
		// call the queue handler asynchronous
		$this->_touchQueue();
		
		// usefull exception for testing
// 		throw new Exception('Disable line ' . __LINE__ . ' of file ' . __FILE__ . ' to enable redirection');
		
		$this->_doRedirect();
	} // redirect();
	
	/**
	 * Handle the actual redirecting. For this redirection, the 302 http code is 
	 * used. This was chosen because browsers cache them for the session, which is
	 * approximately as desired
	 */
	protected function _doRedirect() {
		header("Location: {$this->_currVisit->redirect}", 302);
		exit; 
	} // _doRedirect();
	
	/**
	 * Asynchronously triggers the queue handling
	 */
	protected function _touchQueue() {
		$errno = $errstr = '';
		$params = array();
		$paramString = http_build_query($params);
		if ( !$fp = fsockopen($_SERVER['HTTP_HOST'], 80, $errno, $errstr, 30) ) {
			throw new Exception("Socket error: {$errstr}");
		}
		$dir = array_pop(explode('/', realpath(ROOTDIR)));
		$content = array(
				"POST /{$dir}/visit/handlequeue HTTP:/1.1",
				"Host: {$_SERVER['HTTP_HOST']}",
				"Content-Type: application/x-www-form-urlencoded",
				"Content-Length: " . strlen($paramString),
				"Connection: Close",
				"",
				$paramString
		);
		$content = implode("\r\n", $content);
		fwrite($fp, $content);
		fclose($fp);
	} // _touchQueue();
	
	/**
	 * Handles popping off the queue until no unhandled queue items are left.
	 */
	public function handleQueue() {
		$classes = array();
		while ( $currVisit = DbVisit::getUnhandledVisit() ) {
			$className = $currVisit->type;
			if ( empty($classes[$className]) ) {
				$classes[$className] = new $className;
			}
			$classes[$className]->_handleVisit($currVisit);
		}
		exit;
	} // handleQueue();
	
	/**
	 * Handles a single queueitem
	 * 
	 * @return boolean
	 */
	protected function _handleVisit($currVisit) {
		$this->_responseCache = array();
		$this->_currVisit = $currVisit;

		// set the synchronise started flag to prevent double handling
		$this->_currVisit->synchronise_started = SQLiteObject::getNow();
		$this->_currVisit->store();
		
		// try sending the visit to Carerix, and store succesfull if succesfull, or
		// the failure message if it is not
		try {
			option('CXAppPassword', passLookup($currVisit->app));
			$this->_sendVisitToCX();
			$this->_currVisit->synchronise_finished = SQLiteObject::getNow();
		} catch ( Exception $e ) {
			$this->_currVisit->synchronise_error = $e->getMessage();
		}
		$this->_currVisit->store();
	} // _handleNextVisitOnQueue();
	
	/**
	 * Send a visit to Carerix through the REST api
	 */
	protected function _sendVisitToCX() {
		$this->_checkChecksum($this->_currVisit->checksum);
		$owner = $this->_getOwner();
		if ( empty($owner) ) {
			throw new Exception("Cannot determine owner, so there are probably no usefull fields");
		}
		
		$todoID = $this->_createToDoForVisit();
		if ( !empty($this->_currVisit->employee) )	$this->_linkToDo($todoID, 'Employee', $this->_currVisit->employee);
		if ( !empty($this->_currVisit->contact) )		$this->_linkToDo($todoID, 'User', $this->_currVisit->contact, 'Contact');
		if ( !empty($this->_currVisit->vacancy) )		$this->_linkToDo($todoID, 'Vacancy', $this->_currVisit->vacancy);
	} // _sendVisitToCX();
	
	/**
	 * Check whether the checksum is correct.
	 * 
	 * @param unknown $cs
	 * @throws Exception
	 */
	protected function _checkChecksum($cs) {
		if ( (($cs = $this->_getChecksum()) !== $this->_currVisit->checksum) 
				&& ($this->_getChecksum('hexdec') !== $this->_currVisit->checksum)
				&& ($this->_getChecksum('dechex') !== $this->_currVisit->checksum)
		) {
			throw new Exception("Checksum doesn't check out, should have been '{$cs}'");
		}
	} // _checkChecksum();
	
	/**
	 * Creates a note in CX.
	 * 
	 * @return string
	 */
	protected function _createToDoForVisit() {
		$xml = new DOMDocument;
		$xml->load(realpath(ROOTDIR . '/templates/CRToDo.xml'));
		$xpath = new DOMXPath($xml);
		$xpath->query('/CRToDo/owner/CRUser')->item(0)->setAttribute('id', $this->_getOwner());
		$xpath->query('/CRToDo/subject')->item(0)->appendChild($xml->createTextNode($this->_getSubject()));
		$xpath->query('/CRToDo/notes')->item(0)->appendChild($xml->createTextNode($this->_currVisit->env));
		if ( !($dataNodeID = $this->_getDataNodeID()) ) {
			throw new Exception('No datanode found for required exportcode');
		}
		$xpath->query('/CRToDo/toActivityTypeNode/CRDataNode')->item(0)->setAttribute('id', $dataNodeID);
		if ( !empty($this->_currVisit->email) ) {
			$xpath->query('/CRToDo/toPreviousToDo/CRToDo')->item(0)->setAttribute('id', $this->_currVisit->email);
		}
		$response = $this->_getCxResponseXPath('POST', 'save', $xml->saveXML(), false);
		$todoID = $response->query("/CRToDo")->item(0)->getAttribute('id');
		return $todoID;
	} // _createToDoForVisit();
	
	/**
	 * Returns the subject of the visit
	 * @return string
	 */
	protected function _getSubject() {
		return empty($this->_currVisit->subject) ? $this->_getToDoSubject() : $this->_currVisit->subject;
	} // _getSubject();
	
	/**
	 * Returns the string to be set as subject in the CX Note to be
	 * @return string
	 */
	protected function _getToDoSubject() {
		$cs = array($this->_currVisit->campaign);
		if ( !empty($this->_currVisit->employee) )	$cs []= "Employee: {$this->_currVisit->employee}"; 
		if ( !empty($this->_currVisit->contact) )		$cs []= "Contact: {$this->_currVisit->contact}";
		if ( !empty($this->_currVisit->vacancy) )		$cs []= "Vacancy: {$this->_currVisit->vacancy}";
		if ( !empty($this->_currVisit->email) )			$cs []= "Email: {$this->_currVisit->email}";
		return implode(', ', $cs);
	} // _getToDoSubject();
	
	/**
	 * Links a todo (by its id) to the $type with $id.
	 * 
	 * @param int $todoID
	 * @param string $type
	 * @param int id
	 */
	protected function _linkToDo($todoID, $type, $id, $toType = null) {
		$xml = new DOMDocument;
		if ( $toType === null ) {
			$toType = $type;
		}
		$xml->loadXML("<CRToDo id='{$todoID}'><to{$toType}><CR{$type} id='{$id}'/></to{$toType}></CRToDo>");
		$response = $this->_getCxResponseXPath('POST', 'save', $xml->saveXML(), false);
	} // _linkToDoTo();
	
	/**
	 * Returns the employee of the visit in CX
	 *
	 * @return string
	 */
	protected function _getEmployee($query = null) {
		if ( empty($this->_responseCache[__METHOD__]) ) {
			if ( empty($this->_currVisit->employee) ) {
				throw new Exception('No employee to obtain!');
			}
			$params = array(
					"template" => "object.xml",
					"entity" => "CREmployee",
					"id" => $this->_currVisit->employee,
					"show" => array("owner.toUser.id", "informalName", "stableHash.hexadecimalDescription"),
			);
			$this->_responseCache[__METHOD__] = $this->_getCxResponseXPath('GET', 'view', $params);
		}
		
		if ( $query === null ) {
			return $this->_responseCache[__METHOD__];
		} else if ( $res = $this->_responseCache[__METHOD__]->query($query)->item(0) ) {
			return $res->nodeValue;
		}
		
		$this->_currVisit->employee = null;
		return 0;
	} // _getEmployee();
	
	/**
	 * Returns the employee of the visit in CX
	 *
	 * @return string
	 */
	protected function _getPublication($query = null) {
		if ( empty($this->_responseCache[__METHOD__]) ) {
			if ( empty($this->_currVisit->publication) ) {
				throw new Exception('No publication to obtain!');
			}
			$params = array(
					"template" => "object.xml",
					"entity" => "CRPublication",
					"id" => $this->_currVisit->publication,
					"show" => array("owner.toUser.id", "stableHash.hexadecimalDescription", "toMedium.name", "toVacancy.vacancyID", "toVacancy.jobTitle"),
			);
			$this->_responseCache[__METHOD__] = $this->_getCxResponseXPath('GET', 'view', $params);
		}
		
		if ( $query === null ) {
			return $this->_responseCache[__METHOD__];
		} else if ( $res = $this->_responseCache[__METHOD__]->query($query)->item(0) ) {
			return $res->nodeValue;
		}
		
		$this->_currVisit->publication = null;
		return 0;
	} // _getPublication();
	
	/**
	 * Returns the owner to be of the visit in CX
	 *
	 * @return string
	 */
	protected function _getVacancy($query = null) {
		if ( empty($this->_responseCache[__METHOD__]) ) {
			if ( empty($this->_currVisit->vacancy) ) {
				throw new Exception('No vacancy to obtain!');
			}
			$params = array(
					"template" => "object.xml",
					"entity" => "CRVacancy",
					"id" => $this->_currVisit->vacancy,
					"show" => array("owner.toUser.id", "toCompany.id", "jobTitle", "stableHash.hexadecimalDescription"),
			);
			$this->_responseCache[__METHOD__] = $this->_getCxResponseXPath('GET', 'view', $params);
		}
		
		if ( $query === null ) {
			return $this->_responseCache[__METHOD__];
		} else if ( $res = $this->_responseCache[__METHOD__]->query($query)->item(0) ) {
			return $res->nodeValue;
		}
		
		$this->_currVisit->vacancy = null;
		return 0;
	} // _getVacancy();
	
	/**
	 * Returns the owner to be of the visit in CX
	 *
	 * @return string
	 */
	protected function _getContact($query = null) {
		if ( empty($this->_responseCache[__METHOD__]) ) {
			if ( empty($this->_currVisit->contact) ) {
				throw new Exception('No vacancy to obtain!');
			}
			$params = array(
					"template" => "object.xml",
					"entity" => "CRUser",
					"id" => $this->_currVisit->contact,
					"show" => array("owner.toUser.id", "toCompany.id", "informalName", "stableHash.hexadecimalDescription"),
			);
			$this->_responseCache[__METHOD__] = $this->_getCxResponseXPath('GET', 'view', $params);
		}
		
		if ( $query === null ) {
			return $this->_responseCache[__METHOD__];
		} else if ( $res = $this->_responseCache[__METHOD__]->query($query)->item(0) ) {
			return $res->nodeValue;
		}
		
		$this->_currVisit->contact = null;
		return 0;
	} // _getContact();
	
	/**
	 * Returns the owner to be of the visit in CX
	 *
	 * @return string
	 */
	protected function _getEmail($query = null) {
		if ( empty($this->_responseCache[__METHOD__]) ) {
			if ( empty($this->_currVisit->email) ) {
				throw new Exception('No vacancy to obtain!');
			}
			$params = array(
					"template" => "object.xml",
					"entity" => "CRToDo",
					"id" => $this->_currVisit->email,
					"show" => array("owner.toUser.id", "stableHash.hexadecimalDescription"),
			);
			$this->_responseCache[__METHOD__] = $this->_getCxResponseXPath('GET', 'view', $params);
		}
		
		if ( $query === null ) {
			return $this->_responseCache[__METHOD__];
		} else if ( $res = $this->_responseCache[__METHOD__]->query($query)->item(0) ) {
			return $res->nodeValue;
		}
		
		$this->_currVisit->email = null;
		return 0;
	} // _getEmail();
	
	/**
	 * Returns the correct status of the visit in CX
	 *
	 * @return string
	 */
	protected function _getDataNode($query = null) {
		if ( empty($this->_responseCache[__METHOD__]) ) {
			$params = array(
					"template" => "objects.xml",
					"entity" => "CRDataNode",
					"count" => 1,
					"qualifier" => "exportCode='" . $this->_getRequiredExportCode() . "'",
			);
			$this->_responseCache[__METHOD__] = $this->_getCxResponseXPath('GET', 'view', $params);
		}
		
		if ( $query === null ) {
			return $this->_responseCache[__METHOD__];
		} else if ( $res = $this->_responseCache[__METHOD__]->query($query)->item(0) ) {
			return $res->nodeValue;
		}
		return 0;
	} // _getDataNode();
	
	/**
	 * Returns the export code of the datanode that should be set as type of the
	 * created node.
	 * 
	 * @return string
	 */
	protected function _getRequiredExportCode() {
		return empty($this->_currVisit->exportcode) ? 'COUNTCLICK' : $this->_currVisit->exportcode;
	} // _getRequiredExportCode();
	
	/**
	 * Returns the owner to be of the visit in CX
	 *
	 * @return integer
	 */
	protected function _getOwner() {
		$q = '/*/owner/*/@id';
		switch ( true ) {
			case !empty($this->_currVisit->employee)	: return $this->_getEmployee($q); 
			case !empty($this->_currVisit->contact)		: return $this->_getContact($q);
			case !empty($this->_currVisit->vacancy)		: return $this->_getVacancy($q); 
			case !empty($this->_currVisit->email)			: return $this->_getEmail($q); 
		}
		return 0;
	} // _getOwner();
	
	/**
	 * Returns the employees checksum
	 * @var 	$codec	Callback for the transformation upon the stableHash string.
	 * 
	 * @return string
	 */
	protected function _getChecksum($codec = 'strtolower') {
		$q = '/*/stableHash';
		$cs = array();
		if ( !empty($this->_currVisit->email) )			$cs []= call_user_func_array($codec, array($this->_getEmail($q)));
		if ( !empty($this->_currVisit->vacancy) )		$cs []= call_user_func_array($codec, array($this->_getVacancy($q)));
		if ( !empty($this->_currVisit->employee) )	$cs []= call_user_func_array($codec, array($this->_getEmployee($q)));
		if ( !empty($this->_currVisit->contact) )		$cs []= call_user_func_array($codec, array($this->_getContact($q)));
		return implode('.', $cs);
	} // _getChecksum();
	
	/**
	 * Returns the correct status type to be of the visit in CX
	 *
	 * @return string
	 */
	protected function _getDataNodeID() {
		return $this->_getDataNode('/*/CRDataNode/@id');
	} // _getDataNodeID();
	
	/**
	 * Returns a DOMXPath object for the response to the desired request. 
	 * 
	 * @param		string 		$http_word			[GET, POST, PUT, DELETE]
	 * @param		unknown		$view						The view to request
	 * @param		array			$params					HTTP parameters to pass to the request
	 * @param		boolean		[$doBuildQuery]	If false, the http_build_query method will not be called upon the $params.
	 * @return	DOMXPath
	 */
	protected function _getCxResponseXPath($http_word, $view, $params, $doBuildQuery = true) {
		$context = array(
			'http' => array(
					'method' => $http_word,
					'header' => 'x-cx-pwd: ' . option('CXAppPassword'),
			)
		);
		
		$query = $params;
		if ( $doBuildQuery ) {
			$query = preg_replace('/%5B[0-9]+%5D=/', '=', http_build_query($query));
		}
		
		if ( $http_word === 'POST' ) {
			$context['http']['header'] .= "\r\nContent-type: application/x-www-form-urlencoded\r\n";
			$context['http']['content'] = $query;
		}
		
		// retrieve the requested XML
		$xml = file_get_contents(
				"http://{$this->_currVisit->app}web.carerix.net/cgi-bin/WebObjects/{$this->_currVisit->app}web.woa/wa/" . $view
						. ($http_word == 'GET' ? ('?' . $query) : ''),
				false, 
				stream_context_create($context)
		);
		
		// if this is not an XML: throw exception
		if ( strpos($xml, '<?xml') !== 0 ) {
			throw new Exception("Failed to obtain XML for {$http_word} {$view}: {$xml}");
		}
		
		// create and return the DOMXPath
		$doc = new DOMDocument();
		$doc->formatOutput = true;
		$doc->preserveWhiteSpace = false;
		$doc->loadXML($xml, LIBXML_NOENT);
		return new DOMXPath($doc);
	} // _getCxResponseXPath();
	
} // end class CxVisit