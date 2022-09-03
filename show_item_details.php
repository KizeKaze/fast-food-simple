<?php
include "includes/header.php";
include "includes/nav.php";


if (!$_GET['item']) {
    header('Location: index.php');
    exit();
}

$query = new App\Classes\Query();
$id = sanitize($_GET['item']);

$params = [
    'id' => $id
];

$result = $query->CustomSQL('SELECT * FROM item WHERE id = :id', $params);
if (!$result) {
    $_SESSION['failure'] = 'Sorry, we could not find that item';
    header('Location: index.php');
    exit();
}
echo "This item exists!";

