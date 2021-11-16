<?php

namespace App\Classes;

use PDO;

abstract class Database
{
    public static function getInstance(): PDO
    {
        return new \PDO('mysql:host=localhost;dbname=fast-food', 'root', '');
    }
}
