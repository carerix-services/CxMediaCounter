<?php
class Dispatches {
	/**
	 * Constructor. Everything happens here.
	 */
	public function __construct() {
		$this->_addVisit();
		$this->_addVacancies2Candidates();
		$this->_addVacancies2Contacts();
		$this->_addCandidates2Contacts();
		$this->_addMailopened();
		$this->_addPagevisit();
		$this->_addError();
	} // __construct();
	
	/**
	 * Dispatch for the queue handler 
	 */
	protected function _addVisit() {
		$class = 'CxVisit';
		$verb = 'visit';
		
		dispatch_post(array(	"/{$verb}/handlequeue"),	array($this, "{$class}__handleQueue"));
		dispatch(array(	"/{$verb}/handlequeue"),	array($this, "{$class}__handleQueue"));
		
		$parts = array('app', 'campaign', 'exportcode', 'email', 'checksum');
		dispatch(				"/{$verb}" . str_repeat('/*', count($parts) - 1),				array($this, "{$class}__incomplete"));
		dispatch(array(	"/{$verb}" . str_repeat('/*', count($parts)), $parts),	array($this, "{$class}__redirect"));
		
		array_splice($parts, count($parts) - 1, 0, 'vacancy');
		dispatch(array(	"/{$verb}" . str_repeat('/*', count($parts)), $parts),	array($this, "{$class}__redirect"));
		
		array_splice($parts, count($parts) - 1, 0, 'employee');
		dispatch(array(	"/{$verb}" . str_repeat('/*', count($parts)), $parts),	array($this, "{$class}__redirect"));
		
		array_splice($parts, count($parts) - 1, 0, 'contact');
		dispatch(array(	"/{$verb}" . str_repeat('/*', count($parts)), $parts),	array($this, "{$class}__redirect"));
		dispatch(				"/{$verb}" . str_repeat('/*', count($parts) + 1),				array($this, "{$class}__overcomplete"));
	} // addHandleQueue();
	
	/**
	 * Add the dispatches for vacancies2candidates
	 */
	protected function _addVacancies2Candidates() {
		$class = 'CxVisitVacancies2Candidates';
		$verb = 'vacancies2candidates';
		
		$parts = array('app','customer','campaign','vacancy','employee','email','checksum');
		dispatch(				"/{$verb}" . str_repeat('/*', count($parts) - 1),				array($this, "{$class}__incomplete"));
		dispatch(array(	"/{$verb}" . str_repeat('/*', count($parts)), $parts),	array($this, "{$class}__redirect"));
		dispatch(				"/{$verb}" . str_repeat('/*', count($parts) + 1),				array($this, "{$class}__overcomplete"));
	} // addVacancies2Candidates();
	
	/**
	 * Add the dispatches for vacancies2contacts
	 */
	protected function _addVacancies2Contacts() {
		$class = 'CxVisitVacancies2Contacts';
		$verb = 'vacancies2contacts';
		
		$parts = array('app','customer','campaign','vacancy','contact','email','checksum');
		dispatch(				"/{$verb}" . str_repeat('/*', count($parts) - 1),				array($this, "{$class}__incomplete"));
		dispatch(array(	"/{$verb}" . str_repeat('/*', count($parts)), $parts),	array($this, "{$class}__redirect"));
		dispatch(				"/{$verb}" . str_repeat('/*', count($parts) + 1),				array($this, "{$class}__overcomplete"));
	} // addVacancies2Candidates();
	
	/**
	 * Add the dispatches for candidates2contacts
	 */
	protected function _addCandidates2Contacts() {
		$class = 'CxVisitCandidates2Contacts';
		$verb = 'candidates2contacts';

		$parts = array('app','customer','campaign','employee','contact','email','checksum');
		dispatch(				"/{$verb}" . str_repeat('/*', count($parts) - 1),				array($this, "{$class}__incomplete"));
		dispatch(array(	"/{$verb}" . str_repeat('/*', count($parts)), $parts),	array($this, "{$class}__redirect"));
		dispatch(				"/{$verb}" . str_repeat('/*', count($parts) + 1),				array($this, "{$class}__overcomplete"));
	} // _addCandidates2Contacts();
	
	/**
	 * Add the dispatches for mailopened
	 */
	protected function _addMailopened() {
		$class = 'CxVisitMailopened';
		$verb = 'mailopened';

		$parts = array('app','customer','campaign','nextIsVisitor','visitor','email','checksum','slug');
		dispatch(				"/{$verb}" . str_repeat('/*', count($parts) - 1),				array($this, "{$class}__incomplete"));
		dispatch(array(	"/{$verb}" . str_repeat('/*', count($parts)), $parts),	array($this, "{$class}__redirect"));
		$parts = array('app','customer','campaign','nextIs','visitor1','nextIs','visitor2','email','checksum', 'slug');
		dispatch(				"/{$verb}" . str_repeat('/*', count($parts) - 1),				array($this, "{$class}__incomplete"));
		dispatch(array(	"/{$verb}" . str_repeat('/*', count($parts)), $parts),	array($this, "{$class}__redirect"));
		dispatch(				"/{$verb}" . str_repeat('/*', count($parts) + 1),				array($this, "{$class}__overcomplete"));
	} // _addMailopened();

	/**
	 * Add the dispatches for pagevisit
	 */
	protected function _addPagevisit() {
		$class = 'CxVisitPublication';
		$verb = 'pagevisit';

		$parts = array('app','publication','checksum','slug');
		dispatch(				"/{$verb}" . str_repeat('/*', count($parts) - 1),				array($this, "{$class}__incomplete"));
		dispatch(array(	"/{$verb}" . str_repeat('/*', count($parts)), $parts),	array($this, "{$class}__redirect"));
		dispatch(				"/{$verb}" . str_repeat('/*', count($parts) + 1),				array($this, "{$class}__overcomplete"));
	} // _addPagevisit();
	
	/**
	 * Adds the error type to the dispatches
	 */
	protected function _addError() {
		dispatch('/**', array($this, 'CxError__unknown_path'));
	} // _addError();
	
	/**
	 * Magic caller. Is used to prevent all the models from being loaded by 
	 * default, which should speed up the script execution somewhat. 
	 * This way of dispatching makes the application less monolithic.
	 * 
	 * @param string $name
	 * @param array $arguments
	 * @return mixed
	 */
	function __call($name, $arguments) {
		list($class, $method) = explode('__', $name);
		$class = new $class;
		return call_user_func_array(array($class, $method), $arguments);
	} // __call();
	
} // end class Dispatches
