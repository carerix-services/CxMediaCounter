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
	$appName = strtolower($appName);
	$file = ROOTDIR . '/.passwords.ini';
	
	if ( !is_file($file) ) {
		throw new Exception("XML Password file 'password.ini' is missing");
	}

	$passwords = parse_ini_file($file, true) ;
	if ( empty($passwords['app_xml']) ) {
		throw new Exception("password.ini file is missing 'app_xml' category");
	}
	
	if ( empty($passwords['app_xml'][$appName]) ) {
		throw new Exception("password.ini file does not contain '{$appName}' in 'app_xml' category");
	}
	
	return $passwords['app_xml'][$appName];
} // passLookup();