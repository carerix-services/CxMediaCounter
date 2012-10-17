<?php
class CxVisitMailopened extends CxVisit {
	/**
	 * Holder for the recipienttype (employee or contact)
	 * 
	 * @var string
	 */
	private $_recipientType = '';
	
	/**
	 * Method for obtaining the correct type. This allows me to have code-reuse
	 * for CxVisit. get_called_class() is not an option due to the PHP version on 
	 * the plesk server. 
	 * 
	 * @return string
	 */
	protected function _getType() {
		return __CLASS__;
	} // getType();
	
	/**
	 * (non-PHPdoc)
	 * @see CxVisit::_getRequiredExportCode()
	 */
	protected function _getRequiredExportCode() {
		return empty($this->_currVisit->exportcode) ? 'MAILOPENED' : $this->_currVisit->exportcode;
	} // _getRequiredExportCode();
	
	/**
	 * (non-PHPdoc)
	 * @see CxVisit::_doRedirect()
	 */
	protected function _doRedirect() {
		if ( !empty($this->_currVisit->redirect) ) {
			parent::_doRedirect();
		}
		
		header("content-type: image/gif");
		echo base64_decode("R0lGODlhAQABAIAAAAAAAAAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==");
		exit;
	} // _doRedirect();
	
	/**
	 * Send a visit to Carerix through the REST api
	 */
	protected function _sendVisitToCX() {
		switch ( false ) {
			case empty($this->_currVisit->employee)	: $this->_recipientType = 'employee';	break;
			case empty($this->_currVisit->contact)	: $this->_recipientType = 'contact';	break;
			default: throw new Exception('Unknown type of recipient of mail');
		}
		
		$this->_checkChecksum($this->_currVisit->checksum);
		
		$todoID = $this->_createToDoForVisit();
		
		if ( $this->_recipientType === 'employee' ) {
			$this->_linkToDo($todoID, 'Employee', $this->_currVisit->employee);
		} else if ( $this->_recipientType === 'contact' ) {
			$this->_linkToDo($todoID, 'User', $this->_currVisit->contact, 'Contact');
		}
	} // _sendVisitToCX();
	
	/**
	 * Returns the string to be set as subject in the CX Note to be
	 * @return string
	 */
	protected function _getToDoSubject() {
		return "MAILOPENED {$this->_recipientType} {$this->_currVisit->campaign} recipient=". $this->_getRecipientName();
	} // _getToDoSubject();

	/**
	 * Returns the recipient of the mail (an employee or a contact) 
	 * @return DOMXPath 
	 */
	protected function _getRecipient() {
		return $this->_recipientType === 'employee' ? $this->_getEmployee() : $this->_getContact();
	} // _getRecipient();
	
	/**
	 * Returns the owner to be of the visit in CX
	 *
	 * @return string
	 */
	protected function _getOwner() {
		$response = $this->_getRecipient();
		return $response->query('/*/owner/*/@id')->item(0)->nodeValue;
	} // _getOwner();
	
	/**
	 * Returns the employees checksum
	 * @return string
	 */
	protected function _getChecksum($codec = 'strtolower') {
		$response = $this->_getRecipient();
		$q = $this->_recipientType === 'employee' ? '/*/toUser/CRUser/stableHash' : '/*/stableHash';
		return call_user_func_array($codec, array($response->query($q)->item(0)->nodeValue));
	} // _getChecksum();
	
	/**
	 * Returns the company of the vacancy of the visit in CX
	 *
	 * @return string
	 */
	protected function _getRecipientName() {
		$response = $this->_getRecipient();
		return $response->query('/*/informalName')->item(0)->nodeValue;
	} // _getVacancyName();
	
} // end class CxVisitMailopened;