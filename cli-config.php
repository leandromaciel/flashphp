<?php
// cli-config.php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once "vendor/autoload.php";

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array('src/Factory/'), $isDevMode);


// database configuration parameters
$conn = array(
	'driver' => 'pdo_mysql',
	'host' => '127.0.0.1',
	'dbname' => 'flashphp',
	'user' => 'root',
	'password' => 'root',
	'charset' => 'utf8'
);

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);