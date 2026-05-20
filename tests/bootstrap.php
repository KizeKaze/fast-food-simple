<?php

require __DIR__ . '/../vendor/autoload.php';

$root = dirname(__DIR__);

$envFile = file_exists($root . '/.env.local') ? '.env.local' : '.env';

if (file_exists($root . '/' . $envFile)) {
    $dotenv = Dotenv\Dotenv::createImmutable($root, $envFile);
    $dotenv->load();
} elseif (file_exists($root . '/.env_example')) {
    $dotenv = Dotenv\Dotenv::createImmutable($root, '.env_example');
    $dotenv->load();
}