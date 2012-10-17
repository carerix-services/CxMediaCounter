<?php 
class CxError {
	public function unknown_path() {
		throw new Exception('Path is undefined, please try anew');
	} // unknown_path();
	
	/**
	 * Handles the incompleteness of a path. Called from a different class
	 * @throws Exception
	 */
	public function incomplete($classname) {
		throw new Exception('Path is undefined, please try anew');
	} // unknown_path();
	
} // end class CxError
