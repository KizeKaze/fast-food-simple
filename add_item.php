<?php
// Includes our namespaces
require 'vendor/autoload.php';

$menu = new \App\Classes\Menu();

if ($_POST) {
    $errors = [];
    $Item = new \App\Classes\MenuItem();

    if (empty(trim($_POST['name']))) {
        $errors[] = "Name invalid";
    }
    if (empty(trim($_POST['description']))) {
        $errors[] = "Description invalid";
    }
    $cost = floatval($_POST['cost']);

    if ($cost <= 0) {
        $errors[] = "Cost invalid";
    }
    if (isset($_POST['value'])) {
        $values = $menu->checkType();
        $verified_type = in_array($_POST['value'], $values);
        if ($verified_type) {
            $Item->setType($_POST['value']);
        } else {
            $errors[] = "Invalid Type";
        }
    }

    if (!count($errors)) {
        $Item->setName($_POST['name']);
        $Item->setDescription($_POST['description']);
        $Item->setCost($cost);

        $name = $Item->getName();
        $description = $Item->getDescription();
        $cost = $Item->getCost();
        $type = $Item->getType();

        $param = [
            'name' => $name,
            'description' => $description,
            'cost' => $cost,
            'type' => $type
        ];

        $menu->addRows($param);

        $item_added = [
            'name' => $Item->getName(),
            'description' => $Item->getDescription(),
            'cost' => $Item->getCost(),
            'type' => $Item->getType()
        ];
    }
}

// Display simple form for user
require 'form.php';
