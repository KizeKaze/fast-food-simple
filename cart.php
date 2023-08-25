<?php

use App\Classes\Database;

include "includes/header.php"; ?>
<?php include "includes/nav.php" ?>

<?php
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
    // How would I handle so many variants when the table name changes for selects and inserts? make a function for each case? run this by Tony. Yes
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

       $params = [ 'user_id' => $_SESSION['user_id']];

       $result = $query->CustomSQL('SELECT order_id FROM order_complete WHERE user_id = :user_id', $params);
       //$order_id = $result[0]['order_id'];  seemingly dont need this
       $user_id = $_SESSION['user_id'];
       $params = [
           'user_id' => $user_id,
       ];

        // attempting to use params['user_id'] with this function causes it to blow up with giving it an int, not an array, ect on the SQL.
        // already have a query class in my construct  but its undefined unless I call a new object in the function itsself.
        // ...automatic er what?!
       $cart_object->cartPurchaseCompleted($user_id, $params);

        $_SESSION['message'] = 'Thanks for your purchase, an email will be sent to you shortly with your order receipt';

        $modifyCart->emailItems();

        header('Location: index.php');
        exit();
    }

    if (count($result) <= 0) {
       $errors[] = 'Your shopping cart is empty, try adding an item!';
    }

    $total = 0;
include 'src/forms/cart_form.php';