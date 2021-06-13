<?php
// bootstrap.php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once "vendor/autoload.php";

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/application/models/entities"), $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);
// or if you prefer yaml or XML
//$config = Setup::createXMLMetadataConfiguration(array(__DIR__."/config/xml"), $isDevMode);
//$config = Setup::createYAMLMetadataConfiguration(array(__DIR__."/config/yaml"), $isDevMode);

$host = $_SERVER["HTTP_HOST"]??"";
switch ($host)
{
	case 'serebo.toqueeltimbre.com':
		define('ENVIRONMENT', 'production');
		break;
	default:
		define('ENVIRONMENT', 'development');
}
define('BASEPATH', 'system');
require_once 'application/config/database.php';
//echo"<pre>";var_dump($db[ENVIRONMENT]);exit;
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
