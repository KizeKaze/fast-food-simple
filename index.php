<?php

// Includes our namespaces
require 'vendor/autoload.php';

// Display simple form for user
require 'form.php';

$menu = new \App\Classes\Menu();
$result = $menu->getItems();

if ($_POST) {
    $drink = new \App\Classes\Drink();

    $placeholder = 'http://localhost:8001';
    
    if (empty($_POST['name']))  {
        header($placeholder);
            echo "Name field is empty";
            die();
    }else {
        $drink->setName($_POST['name']);
    }
    
    if (empty($_POST['description'])) {
        header($placeholder);
        echo "Description field is empty";
        die();
    } else {
        $drink->setDescription($_POST['description']);
    }
    
    if (empty($_POST['cost'])) {
        header($placeholder);
        echo "Cost field is empty";
        die();
    } else {
        $drink->setCost($_POST['cost']);
    }

    $name = $drink->getName();
    $description = $drink->getDescription();
    $money = $drink->getCost();

    $param = [
        'name' => $name,
        'description' => $description,
        'cashMONEY' => $money
    ];
    $menu->addRows($param);


    echo "<h1>Drink details</h1>";
    echo "<br>Name: " . $drink->getName();
    echo "<br>Description: " . $drink->getDescription();
    echo "<br>Cost: " . $drink->getCost();
}
