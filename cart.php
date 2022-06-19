<?php

include "includes/header.php"; ?>
<?php include "includes/nav.php" ?>

<?php
    if (empty($_SESSION['user_id'])) {
        header('Location: index.php');
    }

    if (isset($_GET['qty'])) {
        $query = new \App\classes\Query();
        $id = sanitize($_GET['id']);
        $qty = sanitize($_GET['qty']);

        $params = [
            'user_id' => $_SESSION['user_id'],
            'item_id' => $id,
            'qty' => $qty
        ];

        $query->CustomSQL('UPDATE cart SET qty = :qty WHERE user_id = :user_id AND item_id = :item_id', $params);
        $item_added = 'Item updated';
    }

    if (isset($_GET['delete'])) {
        $User = new  \App\classes\User();
        if ($User->isAdmin()) {
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

    $query = new \App\classes\Query();
    $params = [
        'user_id' => $_SESSION['user_id'],
    ];

    $shoppingcart = $query->CustomSQL('SELECT * FROM cart c INNER JOIN item i ON i.id = c.item_id WHERE user_id = :user_id', $params);


    if ($_POST) {

        $grand_total = sanitize($_POST['grand_total']);
        $params = [
            'user_id' => $_SESSION['user_id'],
            'grand_total' => $grand_total
        ];

        // need to foreach through shoppingcart and format an empty string and append to it and once shoppingcart is done
        // hand it itno the SQL statement, make sure sql is not inside of loop.
        //eg ('','',''.'')



       $query->CustomSQL('INSERT INTO order_complete (user_id, date_purchased, grand_total) VALUES (:user_id, now(), :grand_total)', $params);

        }



    $total = 0;
include 'src/forms/cart_form.php';