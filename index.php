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
            $drink->setType($_POST['value']);
        } else {
            $errors[] = "Invalid Type";
        }
    }

    foreach ($errors as $error) {
        echo "<div class='container'>";
        echo $error;
        echo "</div>";
    }
    if ($errors) {
        die();
    }

    $drink->setName($_POST['name']);
    $drink->setDescription($_POST['description']);
    $drink->setCost($cost);

    $name = $drink->getName();
    $description = $drink->getDescription();
    $cost = $drink->getCost();
    $type = $drink->getType();

    $param = [
        'name' => $name,
        'description' => $description,
        'cost' => $cost,
        'type' => $type
    ];

    $menu->addRows($param);

    echo "<h1>Drink details</h1>";
    echo "<br>Name: " . $drink->getName();
    echo "<br>Description: " . $drink->getDescription();
    echo "<br>Cost: " . $drink->getCost();
    echo "<br>Type: " . $drink->getType();
}
