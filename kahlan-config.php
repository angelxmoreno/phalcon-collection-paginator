<?php

use Kahlan\Plugin\Double;
use Phalcon\Di\FactoryDefault as DefaultDi;
use Phalcon\Mvc\Collection\Manager as CollectionManager;

//constants
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

define('ROOT_PATH', dirname(dirname(__DIR__)));

define('SRC_PATH', ROOT_PATH . DS . 'src');
define('SPEC_PATH', ROOT_PATH . DS . 'spec');

define('TESTS_CONFIG_PATH', SPEC_PATH . DS . 'config');
define('TESTS_SUITE_PATH', SPEC_PATH . DS . 'suite');

//CLI override
$commandLine = $this->commandLine();
$commandLine->option('cc', 'default', true);
$commandLine->option('reporter', 'default', 'dot');


//Phalcon Services
$di = new DefaultDi();

$di->setShared('collectionManager', function () {
    return Double::instance([
        'extends' => CollectionManager::class
    ]);
});


$di->setShared('mongo', function () {
    $server = 'mongodb://mongo';
    $db = 'test';

    $mongo = new \MongoClient($server);
    $collection = $mongo->selectDB($db);

    return $collection;
});