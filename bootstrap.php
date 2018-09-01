<?php

use Dotenv\Dotenv;

require_once __DIR__ . '/vendor/autoload.php';

if(!defined('APP_ROOT')) {
    define('APP_ROOT', __DIR__ . '/');
}

if(!defined('CONFIG_FOLDER')) {
    define('CONFIG_FOLDER', APP_ROOT . '/config/');
}

if(!file_exists(CONFIG_FOLDER . '.env')) {
    header('Location: /install');
    die();
}

$dotenv = new Dotenv(CONFIG_FOLDER);
$dotenv->load();

$dotenv->required(['DBHOST', 'DBUSER', 'DBNAME', 'DOMAIN'])->notEmpty();
$dotenv->required(['DBPASS', 'SCRIPTPATH', 'PREFIX']);

$configurations = [
    'DBHOST',
    'DBUSER',
    'DBNAME',
    'DOMAIN',
    'DBPASS',
    'SCRIPTPATH',
    'PREFIX'
];

foreach($configurations as $key) {
    define($key, getenv($key));
}