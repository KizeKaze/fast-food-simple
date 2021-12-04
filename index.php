<?php

// Includes our namespaces
require 'vendor/autoload.php';

// Display simple form for user
require 'form.php';

$menu = new \App\Classes\Menu();
$result = $menu->getItems();

if ($_POST) {
    $drink = new \App\Classes\Drink();

    
    if (empty(trim($_POST['name'])))  {
            echo "Name field is empty";
            die();
    }else {
        $drink->setName($_POST['name']);
    }

    if (empty(trim($_POST['description']))) {
        echo "Description field is empty";
        die();
    } else {
        $drink->setDescription($_POST['description']);
    }
    if (empty($_POST['cost']) || $_POST['cost'] < 0 || is_string($_POST['cost'])){
        echo "Cost field is empty";
        die();
    } else {
        $drink->setCost($_POST['cost']);
    }

    $name = $drink->getName();
    $description = $drink->getDescription();
    $cost = $drink->getCost();

    $param = [
        'name' => $name,
        'description' => $description,
        'cost' => $cost
    ];
    $menu->addRows($param);


    echo "<h1>Drink details</h1>";
    echo "<br>Name: " . $drink->getName();
    echo "<br>Description: " . $drink->getDescription();
    echo "<br>Cost: " . $drink->getCost();
}
