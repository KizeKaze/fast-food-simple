<?php include "includes/header.php"; ?>
<?php include "includes/nav.php";

        if (!$_GET['edit']) {
            header('Location: index.php');
        }

        $item_id = $_GET['edit'];
        $result = $menu->getItem($item_id);

        if (!count($result)) {
            $_SESSION['failure'] = 'What are you doing...';
            header('Location: /index.php');
            exit();
        }

        $id = $result[0]['id'];
        $name = $result[0]['name'];
        $description = $result[0]['description'];
        $cost = $result[0]['cost'];
        $type_id = $result[0]['type_id'];
        $image = $result[0]['image'];
        $previous_image = $result[0]['image'];

        if(isset($_POST['update']) && $_POST['update']) {

            $filename = $_FILES['uploadfile']['name'];
            $temp_name = $_FILES['uploadfile']['tmp_name'];
            $folder = 'src/images/' . $filename;

            $id = $_POST['update'];
            $name = trim($_POST['name']);
            $description = $_POST['description'];
            $cost = floatval($_POST['cost']);
            $type_id = $_POST['type'];
            $image = $filename;

            if (empty($name)) {
                $errors[] = "Invalid Name";
            }

            if (empty($description)) {
                $errors[] = "Invalid Description";
            }

            if ($cost <= 0) {
                $errors[] = "Invalid Cost";
            }

            if (empty($image)) {
                $image = $previous_image;
            }

            if(empty($errors)) {
                $menu->updateItem($id, $name, $description, $cost, $type_id, $image);
                $_SESSION['message'] = 'Item has been updated';
                move_uploaded_file($temp_name, $folder);
                header("Location: edit_menu_item.php?edit=$id");
                exit();
            }

        }
        include 'src/forms/edit_menu_item_form.php';
        ?>
