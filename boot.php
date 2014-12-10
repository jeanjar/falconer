<?php

if (defined('BOOTED')) {
    return;
}

define('BOOTED', true);

define('BASE_DIR', __DIR__.DIRECTORY_SEPARATOR);

require BASE_DIR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';

$di = new Phalcon\DI\FactoryDefault();

$di->setShared('config',
    function() {
        $config = new \Phalcon\Config;
        $config->merge(require BASE_DIR.'config.php');
        return $config;
    });

$di->setShared('db',
    function() use ($di) {
        $config    = $di->get('config');
        $className = '\Phalcon\Db\Adapter\Pdo\\'.$config->database->adapter;
        $options   = $config->database->toArray();
        unset($options['adapter']);
        $db        = new $className($options);
        return $db;
    });
