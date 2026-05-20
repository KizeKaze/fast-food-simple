<?php

namespace App\Classes;

use PDO;

abstract class Database
{

    public static function getInstance(): PDO
    {
        $root = dirname(__DIR__, 2);

        $local = $root . '/.env.local';
        $prod  = $root . '/.env';
        $example = $root . '/.env_example';

        if (file_exists($local)) {
            $env = parse_ini_file($local);
        } elseif (file_exists($prod)) {
            $env = parse_ini_file($prod);
        } elseif (file_exists($example)) {
            // PHPUnit fallback for CI badge
            $env = parse_ini_file($example);
        } else {
            throw new \Exception('No .env or .env.local file found');
        }

        return new PDO($env['MYSQL_HOST'], $env['MYSQL_USERNAME'], $env['MYSQL_PASSWORD']);
    }
}