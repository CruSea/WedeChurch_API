<?php
/**
 * Created by PhpStorm.
 * User: bengeos
 * Date: 4/9/17
 * Time: 8:46 AM
 */
// bootstrap.php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once "vendor/autoload.php";
$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/module/WedeChurch/src/Entities"), $isDevMode,"data/DoctrineORMModule/Proxy",null,false);
// or if you prefer yaml or XML
//$config = Setup::createXMLMetadataConfiguration(array(__DIR__."/config/xml"), $isDevMode);
//$config = Setup::createYAMLMetadataConfiguration(array(__DIR__."/config/yaml"), $isDevMode);
// database configuration parametersgit
$conn = array(
    'dbname' => 'WedeChurch',
    'user' => 'wede_church_admin',
    'password' => 'passadmin',
    'host' => 'localhost',
    'driver' => 'pdo_mysql',
    'charset' => 'utf8',
    'driverOptions' => array(
        1002 => 'SET NAMES utf8'
    )
);

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);