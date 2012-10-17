<?php
/**
 * Configure sets up the limonade options.
 * This method is called within limonade.php and changes the default settings.   
 */
function configure() {

	// Show errors!
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	// Session is not required; turning session off prevents cookie use.
 	option('session', false);

 	// Do not autoload ALL controllers, since our own autoloader will only 
 	// autoload the required ones
 	option('controllers_dir', false);
 	
} // configure();

/**
 * passLookup returns the XML password for the app passed as argument
 * @param string $appName
 * @throws Exception
 * @return string
 */
function passLookup($appName) {
	switch ( strtolower($appName) ) {
		case 'services' :			return 'D8Ara4hE';
		default : 						throw new Exception('Password for ' . $appName . ' is not available');  
	} // switch
} // passLookup();