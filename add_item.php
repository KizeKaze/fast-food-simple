<?php

/**
 * @var \App\Classes\Menu $menu
 */

require_once __DIR__ . '/php-config/init.php';

if ($_POST) {
    $errors = [];
    $Item = new \App\Classes\MenuItem();

    $name = sanitize($_POST['name'] ?? '');
    if (empty($name) || strlen($name) > 100) {
        $errors[] = "Name invalid";
    }

    $description = sanitize($_POST['description'] ?? '');
    if (empty($description) || strlen($description) > 700) {
        $errors[] = "Description invalid";
    }
    $cost = floatval($_POST['cost']);

    if ($cost <= 0 || $cost > 9999 || (!is_finite($cost))) {
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
require __DIR__ . '/src/forms/add_item_form.php';
