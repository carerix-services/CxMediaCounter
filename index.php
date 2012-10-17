<?php
/**
 * This script is based upon the limonade framework
 * 
 * @see https://github.com/sofadesign/limonade
 * @author J. Stafleu 25-sept-2012
 * @copyright Carerix
 */
define('ROOTDIR', dirname(__FILE__) . '/');

require_once 'lib/limonade.php';
require_once 'autoload.php';
require_once 'configure.php';

new Dispatches;
run();