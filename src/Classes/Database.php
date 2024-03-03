<?php

namespace App\Classes;

use PDO;

abstract class Database
{
    public static function getInstance(): PDO
    {
        return new \PDO($_ENV['MYSQL_HOST'], $_ENV['MYSQL_USERNAME'], $_ENV['MYSQL_PASSWORD']);
    }
}