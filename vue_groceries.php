<?php
require 'vendor/autoload.php';

header('Content-Type: application/json');

$query = new \App\classes\Query();

$lists = $query->CustomSQL('SELECT * FROM item i 
                                INNER JOIN type t ON i.type_id = t.type_id');

$types = $query->CustomSQL('SELECT type_id, type FROM type');

$array = [
    'list' => $lists,
    'type' => $types
];

echo json_encode($array);
