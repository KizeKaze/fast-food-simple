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


}