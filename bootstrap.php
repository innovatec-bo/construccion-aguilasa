<?php
// bootstrap.php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
require_once "vendor/autoload.php";
require_once "application/libraries/phpdotenv/vendor/autoload.php";

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/application/models/entities"), $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();
define('ENVIRONMENT', getenv('ENVIRONMENT'));
define('BASEPATH','system');
require_once 'application/config/database.php';
// database configuration parameters
$conn = array(
    'driver' => $db[ENVIRONMENT]['dbdriver'],
    'user' => $db[ENVIRONMENT]['username'],
	'password' => $db[ENVIRONMENT]['password'],
	'host' => $db[ENVIRONMENT]['hostname'],
	'dbname' => $db[ENVIRONMENT]['database']
);

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);
