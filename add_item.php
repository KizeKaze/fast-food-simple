<?php
// Includes our namespaces
require 'vendor/autoload.php';


$menu = new \App\Classes\Menu();

if ($_POST) {
    //including .env here since header is not called until the form is included.
    $dotenv = Dotenv\Dotenv::createImmutable( __DIR__);
    $dotenv->load();
    $errors = [];
    $Item = new \App\Classes\MenuItem();

    if (empty(sanitize($_POST['name']))) {
        $errors[] = "Name invalid";
    }
    if (empty(sanitize($_POST['description']))) {
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
        $filename = $_FILES['uploadfile']['name'];
        $temp_name = $_FILES['uploadfile']['tmp_name'];
        $folder = 'src/images/' . $filename;

        $Item->setName($_POST['name']);
        $Item->setDescription($_POST['description']);
        $Item->setCost($cost);

        $name = $Item->getName();
        $description = $Item->getDescription();
        $cost = $Item->getCost();
        $type = $Item->getType();

        if (empty($filename)) {
            $filename = "coming-soon.jpg";
        }

        $param = [
            'name' => $name,
            'description' => $description,
            'cost' => $cost,
            'type' => $type,
            'image' => $filename
        ];

        $menu->addRows($param);

        move_uploaded_file($temp_name, $folder);

        $item_added = [
            'name' => $Item->getName(),
            'description' => $Item->getDescription(),
            'cost' => $Item->getCost(),
            'type' => $Item->getType(),
            'image' => $filename
        ];
    }
}

// Display simple form for user
require 'src/forms/add_item_form.php';
