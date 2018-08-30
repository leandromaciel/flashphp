<?php
namespace NotifyMe;

use NotifyMe\Singleton;
use PDO;

require_once(CONFIG_PATH.'Settings.php'); 

$Core = Singleton\Core_Singleton::getInstance();

$Smarty = Singleton\Smarty_Singleton::getInstance();
$Smarty->addPluginsDir(SMARTY_PLUGIN_PATH);
$Smarty->setTemplateDir($settings['Template']['dir']);
$Smarty->setCompileDir($settings['Template']['compile_dir']);
$Smarty->setBaseUrl($settings['Router']['base_url']);

$Language = new Core\Language($settings['Language'], $settings['Security']['session_name']);
$Core->setLanguage($Language);
$Smarty->assign('Language', $Language);

$Router = new Core\Router($settings['Router']);
$Core->setRouter($Router);
$Smarty->assign('Router', $Router);

$Security = new Core\Security($settings['Security']);
$Core->setSecurity($Security);
$Smarty->assign('Security', $Security);

try {
    $DBConnection = new PDO("mysql:host={$settings['DB_Factory']['host']};dbname={$settings['DB_Factory']['dbname']}", "{$settings['DB_Factory']['user']}", "{$settings['DB_Factory']['password']}");
    $DB_Factory = new Core\DB_Factory($DBConnection, $settings['DB_Factory']['records_limit']);
    $Core->setDB_Factory($DB_Factory);
    $Smarty->assign('DB_Factory', $DB_Factory);    
} catch(PDOException $Error) {
    $DBConnectionError = $Error->getMessage();
    die($DBConnectionError);
}

$Logger = new Core\Logger($settings['Logger']);
$Core->setLogger($Logger);
$Smarty->assign('Logger', $Logger);

$Message = new Core\Message($settings['Message']);
$Core->setMessage($Message);
$Smarty->assign('Message', $Message);

$Router->configureRoute();

$controller = $Router->getController();
$method = $Router->getMethod();
$params = $Router->getParams();

require_once($Router->getClassPath());

$class = new $controller();

call_user_func_array(array($class, $method), $params);