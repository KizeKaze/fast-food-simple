<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
set_include_path( get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT'] );

require_once __DIR__ . '/../vendor/autoload.php';


$envFile = file_exists(__DIR__ . '/../.env.local') ? '.env.local' : '.env';
$dotenv = Dotenv\Dotenv::createImmutable( __DIR__ . "/..", $envFile);
$dotenv->load();
date_default_timezone_set('America/Chicago');

//instantiate core objects
$menu = new \App\Classes\Menu();
$modifyCart = new \App\Classes\Cart();
