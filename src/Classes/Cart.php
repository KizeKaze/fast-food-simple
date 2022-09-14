<?php

namespace App\Classes;

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


}