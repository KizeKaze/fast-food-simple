<?php
require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable( __DIR__);
$dotenv->load();

header('Content-Type: application/json');

$query = new \App\Classes\Query();

$lists = $query->CustomSQL('SELECT * FROM item i 
                                INNER JOIN type t ON i.type_id = t.type_id');

$types = $query->CustomSQL('SELECT type_id, type FROM type');

$array = [
    'list' => $lists,
    'type' => $types
];

echo json_encode($array);



