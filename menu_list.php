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
    <form action="index.php" method="post">
        <div class="container">
            <div>
                <input type="submit" value="Home">
                <?php $result = $menu->getItems();

                foreach($result as $row) {
                    echo "<div class='menu_result_div'>";

                    $id = $row['id'];
                    $name = $row['name'];
                    $description = $row['description'];
                    $cost = $row['cost'];
                    $type = $row['type'];
                ?>
                <label>ID: <?=$id?></label><br>
                <label>Name: <?=$name?></label><br>
                <label>Description: <?=$description?></label><br>
                <label>Cost: <?=$cost?></label><br>
                <label>Type: <?=$type?></label>

                <?php
                    echo "</div>";
                }
                ?>
            </div>
        </div>
    </form>
</body>
</html>