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

$results = $query->CustomSQL('SELECT * FROM item WHERE id = :id', $params);
$chunk = $results[0];
if (!$chunk) {
    $_SESSION['failure'] = 'Sorry, we could not find that item';
    header('Location: index.php');
    exit();
}

require 'src/forms/show_item_details_form.php';

