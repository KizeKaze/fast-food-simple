<?php
require_once __DIR__ . '/php-config/init.php';

/**
 * @var \App\Classes\Menu $menu
 */

$User = new \App\Classes\User();

if (!$User->loggedIn()) {
    http_response_code(403);
    echo json_encode(["error" => "Unauthorized"]);
    exit();
}

header('Content-Type: application/json');

$request_body = file_get_contents('php://input');
//json_decode($request_body, true) will convert the JSON string into an array
$data = json_decode($request_body, true);

$errors = [];

//validate incoming data
$name = $data['name'] ?? '';
if (empty($name) || strlen($name) > 255) {
    $errors[] = "Name Field is invalid";
}

$description = $data['description'] ?? '';
if (empty($description) || strlen($description) > 500) {
    $errors[] = "Description Field is invalid";
}

$rawCost = $data['cost'] ?? null;

if (!is_numeric($rawCost) || floatval($rawCost) <= 0) {
    $errors[] = "Cost Field is not a number";
} else {
    $cost = floatval($rawCost);
    if ($cost > 9999) {
        $errors[] = "Cost Field is greater than 9999";
    }
}

$type_id = intval($data['type'] ?? 0);
if ($type_id === 0) {
    $errors[] = "Select Field is empty";
}

// If validation failed, return JSON errors
if (!empty($errors)) {
    echo json_encode(["errors" => $errors]);
    exit();
}

$name = sanitize($name);
$description = sanitize($description);

$parameters = [
    'name' => $name,
    'description' => $description,
    'cost' => $cost,
    'type_id' => $type_id
];

$query = new \App\Classes\Query();
$query->insert('item', $parameters);

echo json_encode(["success" => true]);
