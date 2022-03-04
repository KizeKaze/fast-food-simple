<?php include "includes/header.php"; ?>
<?php include "includes/nav.php" ?>

    <div class="container">
        <?php

        if (!$_GET['edit']) {
            header('Location: menu_list.php');
        }

        $item_id = $_GET['edit'];
        $result = $menu->getItem($item_id);
        echo "<div class='menu_result_div'>";
        $id = $result[0]['id'];
        $name = $result[0]['name'];
        $description = $result[0]['description'];
        $cost = $result[0]['cost'];
        $type_id = $result[0]['type_id'];

        if(isset($_POST['update']) && $_POST['update']) {
            $id = $_POST['update'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $cost = $_POST['cost'];
            $type_id = $_POST['type'];
            $menu->updateItem($id, $name, $description, $cost, $type_id);
            header("Location: edit_menu_item.php");
        }

        ?>
        <div class="card">
            <div class="card-body">
                <form action="" method="POST" class="form_index">
                    <input type="hidden" name="edit" value="<?=$item_id;?>">
                    <div>
                        <label class="input-group-addon" for="name"></label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon-description">Name</span>
                            <input type="text" class="form-control" name="name"
                                   value='<?= $name ?>'>
                        </div>
                    </div>

                    <div>
                        <label class="input-group-addon" for="description"></label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon-description">Description</span>
                            <input id="description" name="description" type="text" class="form-control"
                                   value="<?= $description ?>">
                        </div>
                    </div>

                    <div>
                        <label class="input-group-addon" for="cost"></label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon-cost">$</span>
                            <input id="cost" name="cost" type="text" class="form-control" value="<?= $cost ?>">
                        </div>
                    </div>
                    <div>
                        <label class="input-group-addon" for="type"></label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon-select">Type</span>
                            <select class="form-select" name="type" id="type">
                                <?php
                                $types = $menu->getType();
                                $currentType = $type_id;
                                $select = "selected='selected'";
                                foreach ($types as $type) { ?>
                                <?php    if ($type['type_id'] == $currentType) { ?>
                                        <option <?=$select?> value="<?= $type['type_id'] ?>"><?= $type['type'] ?></option>
                                <?php    } else { ?>
                                        <option value="<?= $type['type_id'] ?>"><?= $type['type'] ?></option>
                                <?php     } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-primary" name="update" value=<?=$id ?>>Update</button>
                </form>
            </div>
        </div>
    </div>
<?php include "includes/footer.php"; ?>