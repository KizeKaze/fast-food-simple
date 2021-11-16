<?php

// Includes our namespaces
require 'vendor/autoload.php';

// Display simple form for user
require 'form.php';

$menu = new \App\Classes\Menu();
$result = $menu->getItems();

echo "<pre>";
print_r($result);
echo "</pre>";

if ($_POST) {
    $drink = new \App\Classes\Drink();
    
    if (is_string($_POST['name'])) {
        $drink->setName($_POST['name']);
    }
    
    if (is_string($_POST['description'])) {
        $drink->setDescription($_POST['description']);
    }
    
    if (is_numeric($_POST['cost'])) {
        $drink->setCost($_POST['cost']);
    }
    
    echo "<h1>Drink details</h1>";
    echo "<br>Name: " . $drink->getName();
    echo "<br>Description: " . $drink->getDescription();
    echo "<br>Cost: " . $drink->getCost();
}
