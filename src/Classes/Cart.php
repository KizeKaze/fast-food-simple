<?php

namespace App\Classes;

use PDO;

class Cart
{

    public \App\Classes\Query $query;
    public \App\Classes\Cart $cart_object;
    public \App\Classes\Email $email_object;

    function __construct()
    {
        $this->query = new \App\Classes\Query();
        $this->email_object = new \App\Classes\Email();
    }

    public function checkCart($params)
    {
       return $this->query->CustomSQL('SELECT * FROM cart WHERE item_id = :item_id AND user_id = :user_id', $params);
    }

    public function updateCart($params)
    {
        return $this->query->CustomSQL('UPDATE cart SET qty = :qty WHERE user_id = :user_id AND item_id = :item_id', $params);
    }

    public function insertCart($params)
    {
        $this->query->insert('cart', $params);
    }

    public function checkQty($qty)
    {
        if ($qty < 0 || $qty > 5) {
            $_SESSION['failure'] = 'Qty must be between equal to 1 or up to 5';
            header('Location: index.php');
            exit();
        }
    }

    public function checkId($id)
    {
        if (!is_numeric($id)) {
            $_SESSION['failure'] = 'What are you doing...';
            header('Location: /index.php');
            exit();
        }
    }

    public function emailItems()
    {
        $db = Database::getinstance();

        $order_id = self::getMaxOrderID($db);
        $email_items = self::getUserItemsOrdered($db, $order_id);
        $order_details = self::getUserOrderDetails($db, $order_id);
        $this->email_object->sendEmail($email_items, $order_details);
    }

    public function getMaxOrderID($db)
    {
        $sql = 'SELECT MAX(order_id) as order_id FROM order_item WHERE user_id = ' . $_SESSION['user_id'] . ' ';
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $order_id = $result['order_id'];
    }

    public function getUserItemsOrdered($db, $order_id)
    {
        $sql = 'SELECT * FROM order_item WHERE order_id =' .  $order_id . ' AND user_id =' . $_SESSION['user_id'] . ' ';
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $email_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserOrderDetails($db, $order_id)
    {
        $sql = 'SELECT * FROM order_complete WHERE order_id =' .  $order_id . ' AND user_id =' . $_SESSION['user_id'] . ' ';
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $order_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function CartQueryInsert($params) {
        $query = new \App\Classes\Query();
        return $query->CustomSQL('INSERT INTO order_complete (user_id, date_purchased, grand_total) VALUES (:user_id, now(), :grand_total)', $params);

    }

}