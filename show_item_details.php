<?php
include "includes/header.php";
include "includes/nav.php";

if (isset($_GET['add'])) {
    if (isset($_SESSION['user_role'])) {
        $query = new \App\Classes\Query();

        $item_id = sanitize($_GET['add']);
        $qty = sanitize($_GET['qty']);

        $params = [
            'item_id' => $item_id,
        ];
        //check db for any items already in cart
        $result = $query->CustomSQL('SELECT * FROM cart WHERE item_id = :item_id', $params);
        if (count($result) >= 1) {
            //update instead of insert
            $params = [
                'user_id' => $_SESSION['user_id'],
                'item_id' => $item_id,
                'qty' => $qty
            ];

            $query->CustomSQL('UPDATE cart SET qty = :qty WHERE user_id = :user_id AND item_id = :item_id', $params);
            $_SESSION['message'] = "Item updated in shopping cart";
            header('Location: index.php');
            exit();

        } else {
            $params = [
                'user_id' => $_SESSION['user_id'],
                'item_id' => $item_id,
                'qty' => $qty
            ];

            $query->insert('cart', $params);
            $_SESSION['message'] = 'Item added to shopping cart';
            header('Location: index.php');
            exit();
        }
    }
}

if (!isset($_GET['item'])) {
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

$name = $chunk['name'] ?? null;
$image = $chunk['image'] ?? null;

require 'src/forms/show_item_details_form.php';

