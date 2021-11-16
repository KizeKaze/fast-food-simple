<?php

namespace App\Classes;

use PDO;

abstract class Database
{
    public function getInstance(): PDO
    {
        return new \PDO('mysql:host=localhost;dbname=test', 'root', '');
    }
}
