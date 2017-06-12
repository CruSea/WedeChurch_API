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

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
//$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/module/TheTender/src/Entities"), $isDevMode,null,null,false);
//$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/module/BuildingManagement/src/Entities"), $isDevMode,null,null,false);
//$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/module/NewTender/src/Entities"), $isDevMode,null,null,false);
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/module/NegaritSMS/src/Entities"), $isDevMode,"data/DoctrineORMModule/Proxy",null,false);
// or if you prefer yaml or XML
//$config = Setup::createXMLMetadataConfiguration(array(__DIR__."/config/xml"), $isDevMode);
//$config = Setup::createYAMLMetadataConfiguration(array(__DIR__."/config/yaml"), $isDevMode);

// database configuration parametersgit
$conn = array(
    'dbname' => 'NegaritSMS',
    'user' => 'bengeos',
    'password' => 'passben',
    'host' => 'localhost:8889',
    'driver' => 'pdo_mysql',
    'charset' => 'utf8',
    'driverOptions' => array(
        1002 => 'SET NAMES utf8'
    )
);

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);