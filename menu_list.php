<?php
require 'vendor/autoload.php';
$menu = new \App\Classes\Menu();


?>

<html>
<head>
    <title>Menu List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <div class="topnav">
        <a href="index.php">Home</a>
        <a class="active" href="menu_list.php">Menu List</a>
        <div class="search-container">
            <form action="menu_list.php" method="post">
                <input type="text" name="search" placeholder="Search...">
                <input type="submit" name="submit">
            </form>
        </div>
    </div>
</div>
<div class="container">
    <div>

        <?php

        if (isset($_POST['submit'])) {
            $search = trim(htmlspecialchars($_POST['search']));

            $result = $menu->getSearch($search);

            if(!($result)) {
                echo "No search result found";
            } else {
                foreach ($result as $row) {
                    echo "<div class='menu_result_div'>";

                    $id = $row['id'];
                    $name = $row['name'];
                    $description = $row['description'];
                    $cost = $row['cost'];
                    $type = $row['type'];
                    ?>
                    <label>ID: <?= $id ?></label><br>
                    <label>Name: <?= $name ?></label><br>
                    <label>Description: <?= $description ?></label><br>
                    <label>Cost: <?= $cost ?></label><br>
                    <label>Type: <?= $type ?></label>
                    <?php
                    echo "</div>";
                }
            }
        } else {
            $result = $menu->getItems();

            foreach ($result as $row) {
                echo "<div class='menu_result_div'>";

                $id = $row['id'];
                $name = $row['name'];
                $description = $row['description'];
                $cost = $row['cost'];
                $type = $row['type'];
                ?>
                <label>ID: <?= $id ?></label><br>
                <label>Name: <?= $name ?></label><br>
                <label>Description: <?= $description ?></label><br>
                <label>Cost: <?= $cost ?></label><br>
                <label>Type: <?= $type ?></label>

                <?php
                echo "</div>";
            }
        }

        ?>
    </div>
</div>
</body>
</html>