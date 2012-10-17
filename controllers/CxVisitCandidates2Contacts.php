<?php
class CxVisitCandidates2Contacts extends CxVisit {
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
		return empty($this->_currVisit->exportcode) ? 'CANDS2CONTACTS' : $this->_currVisit->exportcode;
	} // _getRequiredExportCode();
	
	/**
	 * Send a visit to Carerix through the REST api
	 */
	protected function _sendVisitToCX() {
		$this->_checkChecksum($this->_currVisit->checksum);
		$todoID = $this->_createToDoForVisit();
		$this->_linkToDo($todoID, 'Employee', $this->_currVisit->employee);
		$this->_linkToDo($todoID, 'Company', $this->_getCompany());
		$this->_linkToDo($todoID, 'User', $this->_currVisit->contact, 'Contact');		
	} // _sendVisitToCX();
	
	/**
	 * Returns the string to be set as subject in the CX Note to be
	 * @return string
	 */
	protected function _getToDoSubject() {
		return "CLICK cand2cp {$this->_currVisit->campaign} cand=". $this->_getEmployeeName();
	} // _getToDoSubject();
	
	/**
	 * Returns the owner to be of the visit in CX
	 *
	 * @return string
	 */
	protected function _getOwner() {
		$response = $this->_getEmployee();
		return $response->query('/*/owner/*/@id')->item(0)->nodeValue;
	} // _getOwner();
	
	/**
	 * Returns the employees checksum
	 * @return string
	 */
	protected function _getChecksum($codec = 'strtolower') {
		$response = $this->_getEmployee();
		return call_user_func_array($codec, array($response->query('/*/toUser/CRUser/stableHash')->item(0)->nodeValue));
	} // _getChecksum();
	
	/**
	 * Returns the company of the vacancy of the visit in CX
	 *
	 * @return string
	 */
	protected function _getCompany() {
		$response = $this->_getContact();
		return $response->query('/*/toCompany/*/@id')->item(0)->nodeValue;
	} // _getCompany();
	
	/**
	 * Returns the company of the vacancy of the visit in CX
	 *
	 * @return string
	 */
	protected function _getEmployeeName() {
		$response = $this->_getEmployee();
		return $response->query('/*/informalName')->item(0)->nodeValue;
	} // _getVacancyName();
	
} // end class CxVisitCandidates2Contacts;