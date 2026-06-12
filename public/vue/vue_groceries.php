<?php
require_once __DIR__ . '/../../php-config/init.php';

$User = new \App\Classes\User();

// Require login (NOT admin) so recruiters can still see it
if (!$User->loggedIn()) {
    http_response_code(403);
    echo json_encode(["error" => "Unauthorized"]);
    exit();
}

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



