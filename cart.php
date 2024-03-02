<?php

use App\Classes\Database;

include "includes/header.php";
include "includes/nav.php";


    $cart_object = new \App\Classes\Cart();

    if (empty($_SESSION['user_id'])) {
        header('Location: index.php');
    }

    if (isset($_GET['qty'])) {
        $query = new \App\Classes\Query();
        $id = sanitize($_GET['id']);
        $qty = sanitize($_GET['qty']);

        if ($qty < 0 || $qty > 5) {
            $_SESSION['failure'] = 'Qty must be between equal to 1 or up to 5';
            header('Location: cart.php');
            exit();
        }

        if (!is_numeric($id)) {
            $_SESSION['failure'] = 'What are you doing...';
            header('Location: cart.php');
            exit();
        }


        $params = [
            'user_id' => $_SESSION['user_id'],
            'item_id' => $id,
            'qty' => $qty
        ];

        $modifyCart->updateCart($params);
        $item_added = 'Item updated';
    }

    if (isset($_GET['delete'])) {
        $User = new  \App\Classes\User();
        if ($User->loggedIn()) {
            $id = $_GET['delete'];

            $params = [
                'item_id' => $id,
                'user_id' => $_SESSION['user_id']
            ];

            $query = new \App\Classes\Query();
            $query->CustomSQL('DELETE FROM cart WHERE user_id = :user_id AND item_id = :item_id', $params);
            $item_added = 'Item deleted from shopping cart';
        }
    }
    $query = new \App\Classes\Query();

    $params = [
        'user_id' => $_SESSION['user_id'],
    ];

    //grab cart for compare on cart_form.php
    $cart_amount = $query->CustomSQL('SELECT COUNT(*) AS amount FROM cart WHERE user_id = ' . $_SESSION['user_id']);


    $shoppingcart = $query->CustomSQL('SELECT * FROM cart c INNER JOIN item i ON i.id = c.item_id WHERE user_id = :user_id', $params);

    $params = [
        'user_id' => $_SESSION['user_id']
    ];
    $result = $query->CustomSQL('SELECT * FROM cart WHERE user_id = :user_id', $params);

    if ($_POST) {

        $grand_total = sanitize($_POST['grand_total']);

        $params = [
            'user_id' => $_SESSION['user_id'],
            'grand_total' => $grand_total
        ];

       $cart_object->insertOrderComplete($params);

       $params = ['user_id' => $_SESSION['user_id']];

       $result = $query->CustomSQL('SELECT order_id FROM order_complete WHERE user_id = :user_id', $params);
       $user_id = $_SESSION['user_id'];
       $params = [
           'user_id' => $user_id,
       ];

       $cart_object->cartPurchaseCompleted($params, $user_id);

        $_SESSION['message'] = 'Thanks for your purchase. An email will be sent to you shortly with your order receipt in your Inbox or Spam folder';

        $modifyCart->getMaxOrderID();





        //original line sitting here before tring to dissect emailitems
       // $modifyCart->emailItems();

        include 'cron_job_email.php';

        header('Location: index.php');

        exit();
    }

    if (count($result) <= 0) {
       $errors[] = 'Your shopping cart is empty, try adding an item!';
    }

    $total = 0;
include 'src/forms/cart_form.php';