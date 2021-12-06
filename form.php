<?php $menu = new \App\Classes\Menu() ?>
<html lang="en">
<head>
    <title>Fast Food</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h3>Add an item to the menu</h3>
    <form action="submit" method="post" class="form_index">
        <div>
            <div>
                <label for="name">Name:</label>
            </div>
            <div>
                <input id="name" name="name" type="text"/>
            </div>
        </div>

        <div>
            <label for="description">Description:</label>
            <input id="description" name="description" type="text"/>
        </div>

        <div>
            <label for="cost">Cost:</label>
            <input id="cost" name="cost" type="text"/>
        </div>

        <div>
            <label for="type">Type:</label>
            <select name="value" id="type">
                <?php

                $types = $menu->getType();

                foreach ($types as $type) { ?>
                    <option value="<?= $type['type_id'] ?>"><?= $type['type'] ?></option>
                <?php } ?>
            </select>
        </div>

        <br>
        <button>Submit</button>
    </form>
    <form action="menu_list.php" method="post">
        <input type="submit" name="submit" value="Menu List">
    </form>
</div>
</body>
</html>