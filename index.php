<?php

// Includes our namespaces
require 'vendor/autoload.php';

// Display simple form for user
require 'form.php';

$menu = new \App\Classes\Menu();
$result = $menu->getItems();

if ($_POST) {
    $errors = [];
    $drink = new \App\Classes\Drink();

    
    if (empty(trim($_POST['name'])))  {
            $errors[] = "Name field is empty";
    }else {
        $drink->setName($_POST['name']);
    }

    if (empty(trim($_POST['description']))) {
        $errors[] = "Description field is empty";

    } else {
        $drink->setDescription($_POST['description']);
    }
    
    if (empty($_POST['cost']) || $_POST['cost'] < 0){
        $errors[] = "Cost field is empty";
    } else {
        $drink->setCost($_POST['cost']);
    }
        foreach($errors as $error) {
            echo "<div class='container'>";
            print_r($error);
            echo "</div>";
        }
    if($errors) {
            die();
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
