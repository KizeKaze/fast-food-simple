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

        if (file_exists($local)) {
            $env = parse_ini_file($local);
        } elseif (file_exists($prod)) {
            $env = parse_ini_file($prod);
        } else {
            // PHPUnit fallback for CI badge
            $host = 'mysql:host=localhost;dbname=fast_food';
            $user = 'root';
            $pass = '';

            return new PDO($host, $user, $pass);
        }

        return new PDO($env['MYSQL_HOST'], $env['MYSQL_USERNAME'], $env['MYSQL_PASSWORD']);
    }
}