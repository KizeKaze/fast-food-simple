<?php

use App\Classes\Database;

include "includes/header.php"; ?>
<?php include "includes/nav.php" ?>

<?php
    if (empty($_SESSION['user_id'])) {
        header('Location: index.php');
    }

    if (isset($_GET['qty'])) {
        $query = new \App\Classes\Query();
        $id = sanitize($_GET['id']);
        $qty = sanitize($_GET['qty']);

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


        $db = Database::getinstance();
        $grand_total = sanitize($_POST['grand_total']);

        $params = [
            'user_id' => $_SESSION['user_id'],
            'grand_total' => $grand_total
        ];

       $query->CustomSQL('INSERT INTO order_complete (user_id, date_purchased, grand_total) VALUES (:user_id, now(), :grand_total)', $params);


       $params = [ 'user_id' => $_SESSION['user_id']];

       $result = $query->CustomSQL('SELECT order_id FROM order_complete WHERE user_id = :user_id', $params);
       $order_id = $result[0]['order_id'];
       $user_id = $_SESSION['user_id'];

       $sql = 'INSERT INTO order_item SELECT (SELECT MAX(order_id)
        FROM order_complete WHERE user_id = c.user_id) AS order_id, c.user_id, i.id AS item_id, i.name AS item_name, i.cost, c.qty FROM cart c
        INNER JOIN item i on c.item_id = i.id WHERE user_id =' . $user_id . ' ';

        $stmt = $db->prepare($sql);

        $stmt->execute();
        $query->CustomSQL('DELETE FROM cart WHERE user_id = :user_id', $params);

        $_SESSION['message'] = 'Thanks for your purchase, an email will be sent to you shortly with your order receipt';

        header('Location: index.php');
        exit();
    }

    if (count($result) <= 0) {
       $errors[] = 'Your shopping cart is empty, try adding an item!';
    }

    $total = 0;
include 'src/forms/cart_form.php';