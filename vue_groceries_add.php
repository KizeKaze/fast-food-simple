<?php

// if this were live production I would have variables checking if anyone is logged in and an admin before letting this run

require 'vendor/autoload.php';

    $request_body = file_get_contents('php://input');

    $data = json_decode($request_body);

    $query = new \App\classes\Query();

    $parameters = [
        'name' => sanitize($data->name),
        'description' => sanitize($data->description),
        'cost' => sanitize($data->cost),
        'type_id' => sanitize($data->type),

    ];

    $query->insert('item', $parameters);

