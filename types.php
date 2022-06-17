<?php
include "includes/header.php";
include "includes/nav.php";

if(!isset($_SESSION['user_role'])) {
    header("Location: index.php");
    exit();
}

if(isset($_GET['delete'])) {
    if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 1){
        $id = $_GET['delete'];

        $params = [
            'type_id' => $id
        ];
        $query = new \App\Classes\Query();

        $result = $query->CustomSQL('SELECT type_id FROM item WHERE type_id = :type_id', $params);

        if (count($result) >= 1) {
            $errors[] = 'Items in item table depend on type: ID ' . $params['type_id'] . ', ACCESS DENIED';
        } else {
            $query->CustomSQL('DELETE FROM type WHERE type_id = :type_id', $params);
        }
    }
}

if(isset($_GET['add'])) {
    if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 1){
        $type = sanitize($_GET['add']);

        $param = [
            'type' => $type
        ];
        $query = new \App\Classes\Query();

        $query->insert('type', $param);
    }
}

if(isset($_POST['type_edit'])) {
    $query = new \App\Classes\Query();
    $id = sanitize($_POST['id']);
    $type = sanitize($_POST['type_edit']);

    if(empty($type)) {
        $errors[] = 'Edit field is blank, edit rejected';
    } else {
        $param = [
            'type' => $type
        ];
        $query->CustomSQL('UPDATE type SET type = :type WHERE type_id = ' . $id . ' ', $param);
    }
}

$types = $menu->getTypes();

include 'src/forms/types_form.php';