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
	return secretLookup($appName, 'app_xml');
} // passLookup();

/**
 * tokenLookup returns the token for the app passed as argument
 * 
 * @param string $appName
 * @throws Exception
 * @return string
 */
function tokenLookup($appName) {
	return secretLookup($appName, 'app_token');
} // tokenLookup();

/**
 * secretLookup returns the secret for $appname useable for $domain
 *
 * @param string $appName
 * @param string $domain
 * @throws Exception
 * @return string
 */
function secretLookup($appName, $domain) {
	$appName = strtolower($appName);
	$file = ROOTDIR . '/.passwords.ini';
	
	if ( !is_file($file) ) {
		throw new Exception("Password file '.password.ini' is missing");
	}

	$passwords = parse_ini_file($file, true) ;
	
	if ( empty($passwords[$domain]) ) {
		throw new Exception(".password.ini file is missing '{$domain}' category");
	}
	
	if ( empty($passwords[$domain][$appName]) ) {
		throw new Exception(".password.ini file does not contain '{$appName}' in '{$domain}' category");
	}
	
	return empty($passwords[$domain][$appName]) ? false : $passwords[$domain][$appName];
} // secretLookup();