<?php
class CxVisitPublication extends CxVisit {
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
		return empty($this->_currVisit->exportcode) ? 'PAGEVISIT' : $this->_currVisit->exportcode;
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
		$this->_checkChecksum($this->_currVisit->checksum);
		
		$todoID = $this->_createToDoForVisit();
		$this->_linkToDo($todoID, 'Vacancy', $this->_getVacancyID());
	} // _sendVisitToCX();
	
	/**
	 * Returns the string to be set as subject in the CX Note to be
	 * @return string
	 */
	protected function _getToDoSubject() {
		$medium = $this->_getMedium();
		$jobTitle = $this->_getJobTitle();
		$jobID = $this->_getVacancyID();
		return "{$this->_currVisit->publication}-{$medium}: {$jobTitle} [{$jobID}]";
	} // _getToDoSubject();
	
	/**
	 * Returns the owner to be of the visit in CX
	 *
	 * @return string
	 */
	protected function _getOwner() {
		$response = $this->_getPublication();
		return $response->query('/*/owner/*/@id')->item(0)->nodeValue;
	} // _getOwner();
	
	/**
	 * Returns the checksum
	 * @return string
	 */
	protected function _getChecksum($codec = 'strtolower') {
		$response = $this->_getPublication();
		return call_user_func_array($codec, array($response->query('/*/stableHash')->item(0)->nodeValue));
	} // _getChecksum();
	
	/**
	 * Returns the checksum
	 * @return string
	 */
	protected function _getMedium() {
		$response = $this->_getPublication();
		return $response->query('/*/toMedium/CRMedium/name')->item(0)->nodeValue;
	} // _getMedium();
	
	/**
	 * Returns the checksum
	 * @return string
	 */
	protected function _getJobTitle() {
		$response = $this->_getPublication();
		return $response->query('/*/toVacancy/CRVacancy/jobTitle')->item(0)->nodeValue;
	} // _getJobTitle();
	
	/**
	 * Returns the checksum
	 * @return string
	 */
	protected function _getVacancyID() {
		$response = $this->_getPublication();
		return $response->query('/*/toVacancy/CRVacancy/vacancyID')->item(0)->nodeValue;
	} // _getVacancyID();
	
} // end class CxVisitPublication;