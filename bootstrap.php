<?php
use Doctrine\ORM\EntityManager,
	Doctrine\ORM\Configuration;

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();
define('ENVIRONMENT', getenv('ENVIRONMENT'));
define('BASEPATH','system');
require_once 'application/config/database.php';
// ...

if (ENVIRONMENT == "development") {
	$cache = new \Doctrine\Common\Cache\ArrayCache;
} else {
	$cache = new \Doctrine\Common\Cache\ApcCache;
}

$config = new Configuration;
$config->setMetadataCacheImpl($cache);
$driverImpl = $config->newDefaultAnnotationDriver(__DIR__."/application/models/entities");
$config->setMetadataDriverImpl($driverImpl);
$config->setQueryCacheImpl($cache);
$config->setProxyDir(__DIR__."/application/model/Proxies");
$config->setProxyNamespace('Serebo\Proxies');

if (ENVIRONMENT == "development") {
	$config->setAutoGenerateProxyClasses(true);
} else {
	$config->setAutoGenerateProxyClasses(false);
}

//$connectionOptions = array(
//	'driver' => 'pdo_sqlite',
//	'path' => 'database.sqlite'
//);
$connectionOptions = array(
	'driver' => $db[ENVIRONMENT]['dbdriver'],
	'user' => $db[ENVIRONMENT]['username'],
	'password' => $db[ENVIRONMENT]['password'],
	'host' => $db[ENVIRONMENT]['hostname'],
	'dbname' => $db[ENVIRONMENT]['database']
);

$entityManager = EntityManager::create($connectionOptions, $config);
