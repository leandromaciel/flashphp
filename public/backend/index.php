<?php
header('Content-Type: text/html; charset=utf-8');

/*
 *---------------------------------------------------------------
 * APPLICATION TYPE
 *---------------------------------------------------------------
 *
 * You can load different configurations depending on your
 * current application. This will set wether it is an backend or
 * frontend application.
 *
 * This can be set as:
 *
 *     Backend/
 *     Frontend/
 *
 */

define('APPLICATION', 'Backend');

/*
 *---------------------------------------------------------------
 * APPLICATION ENVIRONMENT
 *---------------------------------------------------------------
 *
 * You can load different configurations depending on your
 * current environment. Setting the environment also influences
 * things like logging and error reporting.
 *
 * This can be set to anything, but default usage is:
 *
 *     Development
 *     Homolog
 *     Production
 *
 * NOTE: If you change these, also change the error_reporting() code below
 */
define('ENVIRONMENT', 'Development');

/*
 *---------------------------------------------------------------
 * ERROR REPORTING
 *---------------------------------------------------------------
 *
 * Different environments will require different levels of error reporting.
 * By default development will show errors but testing and live will hide them.
 */
switch (ENVIRONMENT) {
	case 'Development':
		error_reporting(-1);
		ini_set('display_errors', 1);
		break;

	case 'Homolog':
	case 'Production':
		ini_set('display_errors', 0);
		if (version_compare(PHP_VERSION, '5.3', '>=')) {
			error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
		} else {
			error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
		}
		break;

	default:
		header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
		echo 'The application environment is not set correctly.';
		exit(1); // EXIT_ERROR
}

/*
 *---------------------------------------------------------------
 * Core Path
 *---------------------------------------------------------------
 *
 * Here you set where the Core Objects will be placed with the trailing slash "/"
 *
 */
define('CORE_PATH', '../../src/Core/');


/*
 *---------------------------------------------------------------
 * Factory Path
 *---------------------------------------------------------------
 *
 * Here you set where the Factory Objects will be placed with the trailing slash "/"
 *
 */
define('FACTORY_PATH', '../../src/Factory/');


/*
 *---------------------------------------------------------------
 * Helper Path
 *---------------------------------------------------------------
 *
 * Here you set where the Helpers will be placed with the trailing slash "/"
 *
 */
define('HELPER_PATH', '../src/Helper/');



/*
 *---------------------------------------------------------------
 * Proxy Path
 *---------------------------------------------------------------
 *
 * Here you set where the Factory Proxies Objects will be placed with the trailing slash "/"
 *
 */
define('PROXY_PATH', '../../src/Factory/Proxies/');



/*
 *---------------------------------------------------------------
 * Smarty Plugin Path
 *---------------------------------------------------------------
 *
 * Here you set where the Smarty_plugin helpers will be placed with the trailing slash "/"
 *
 */
define('SMARTY_PLUGIN_PATH', HELPER_PATH.'Smarty/');


/*
*---------------------------------------------------------------
* Config Path
*---------------------------------------------------------------
*
* Here you set where the Config for your APPLICATION will be placed with the trailing slash "/"
*
*/
define('CONFIG_PATH', '../../src/Config/'.APPLICATION.'/');


/*
 *---------------------------------------------------------------
 * Model Path
 *---------------------------------------------------------------
 *
 * Here you set where the Models for your APPLICATION will be placed with the trailing slash "/"
 *
 */
define('MODEL_PATH', '../../src/Model/'.APPLICATION.'/');


/*
 *---------------------------------------------------------------
 * View Path
 *---------------------------------------------------------------
 *
 * Here you set where the Views for your APPLICATION will be placed with the trailing slash "/"
 *
 */
define('VIEW_PATH', '../../src/View/'.APPLICATION.'/');


/*
 *---------------------------------------------------------------
 * Controller Path
 *---------------------------------------------------------------
 *
 * Here you set where the Controllers for your APPLICATION will be placed with the trailing slash "/"
 *
 */
define('CONTROLLER_PATH', '../../src/Controller/'.APPLICATION.'/');

/*
 *---------------------------------------------------------------
 * Language Path
 *---------------------------------------------------------------
 *
 * Here you set where the Language files for your APPLICATION will be placed with the trailing slash "/"
 *
 */
define('LANGUAGE_PATH', '../../src/Language/'.APPLICATION.'/');


/*
*---------------------------------------------------------------
* Language Path
*---------------------------------------------------------------
*
* Here you set where the Language files for your APPLICATION will be placed with the trailing slash "/"
*
*/
define('LOG_PATH', '../../src/Logs/'.APPLICATION.'/');


/*
 *---------------------------------------------------------------
 * Default 404 Action
 *---------------------------------------------------------------
 *
 * Here you set wich Controller/Method Router will call in case of not finding corresponding route
 *
 */
define('DEFAULT_404', 'Main/Error404');


/*
 *---------------------------------------------------------------
 * Default Controller
 *---------------------------------------------------------------
 *
 * Here you set wich Controller/Method Router will call as the default Controller
 *
 */
define('DEFAULT_CONTROLLER', 'Main/index');

require_once('../../vendor/autoload.php');
require_once(CORE_PATH . 'Init.php');