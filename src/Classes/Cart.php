<?php

namespace App\Classes;

use PDO;

class Cart
{

    public \App\Classes\Query $query;

    function __construct()
    {
        $this->query = new \App\Classes\Query();
    }

    function checkCart($params)
    {
       return $this->query->CustomSQL('SELECT * FROM cart WHERE item_id = :item_id AND user_id = :user_id', $params);
    }

    function updateCart($params)
    {
        return $this->query->CustomSQL('UPDATE cart SET qty = :qty WHERE user_id = :user_id AND item_id = :item_id', $params);
    }

    function insertCart($params)
    {
        $this->query->insert('cart', $params);
    }

    function checkQty($qty)
    {
        if ($qty < 0 || $qty > 5) {
            $_SESSION['failure'] = 'Qty must be between equal to 1 or up to 5';
            header('Location: index.php');
            exit();
        }
    }

    function checkId($id)
    {
        if (!is_numeric($id)) {
            $_SESSION['failure'] = 'What are you doing...';
            header('Location: /index.php');
            exit();
        }
    }

    function emailItems()
    {
        $db = Database::getinstance();
        $sql = 'SELECT MAX(order_id) as order_id FROM order_item WHERE user_id = ' . $_SESSION['user_id'] . ' ';
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $order_id = $result['order_id'];

        $sql = 'SELECT * FROM order_item WHERE order_id =' .  $order_id . ' AND user_id =' . $_SESSION['user_id'] . ' ';
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $email_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $sql = 'SELECT * FROM order_complete WHERE order_id =' .  $order_id . ' AND user_id =' . $_SESSION['user_id'] . ' ';

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $order_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $i = 1;

        $to = $_SESSION['email'];
        $subject = "Receipt From rayxproject.com";

        $headers = "From: Admin@rayxproject.com" . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        ob_start();
        include 'src/forms/email_items_form.php';
        $msg = ob_get_contents();
        ob_end_clean();
        $msg = wordwrap($msg,70);
        mail($to, $subject, $msg, $headers);

    }


}