<?php
$settings['DB_Factory']['driver'] = 'pdo_mysql';
$settings['DB_Factory']['host'] = 'localhost';
$settings['DB_Factory']['dbname'] = 'flashphp';
$settings['DB_Factory']['user'] = 'root';
$settings['DB_Factory']['password'] = 'root';
$settings['DB_Factory']['charset'] = 'utf8';
$settings['DB_Factory']['records_limit'] = 1000;


$settings['Language']['dir'] = LANGUAGE_PATH;
$settings['Language']['files'][] = 'pt_br';
$settings['Language']['files'][] = 'en_us';


$settings['Template']['dir'] = VIEW_PATH.'templates/';
$settings['Template']['compile_dir'] = VIEW_PATH.'/templates_c/';


$settings['Router']['dir'] = CONFIG_PATH;
$settings['Router']['base_url'] = 'http://localhost/flashphp/public_html/admin';
$settings['Router']['error_403'] = 'Main/error403';
$settings['Router']['error_404'] = 'Main/error404';


$settings['Security']['redirect_path'] = $settings['Router']['base_url'];
$settings['Security']['session_name'] = 'FlashPHP_Session_Backend';
$settings['Security']['session_entity'] = 'user';
$settings['Security']['session_entity_field'] = 'session_id';
$settings['Security']['csrf_token'] = true;
$settings['Security']['csrf_token_name'] = 'notifyme_csrf_token_backend';


$settings['Logger']['output'] = 'file';
$settings['Logger']['file_name'] = date('Y-m-d').'.log';
$settings['Logger']['mode'] = 0600;
$settings['Logger']['timeFormat'] = '%d/%m/%Y %H:%M:%S';


$settings['Message']['error_class'] = '.error';