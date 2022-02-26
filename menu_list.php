<?php include "includes/header.php"; ?>
<?php include "includes/nav.php" ?>


    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="menu_list.php" method="post">
                    <select name="type">
                        <option value="0">All</option>
                        <?php $results = $menu->getType() ?>
                        <?php foreach ($results as $row) {
                            echo "<option value=" . $row['type_id'] . ">" . $row['type'] . "</option>";
                        } ?>
                    </select>
                    <input type="text" name="search" placeholder="Search...">
                    <input type="submit" name="submit">
                </form>
            </div>
        </div>
    </div>

    <div class="container">
<?php
if (isset($_POST['submit']) || isset($_POST['type'])) {
    $type = trim(htmlspecialchars($_POST['type']));
    $search = trim(htmlspecialchars($_POST['search']));
    $result = $menu->getSearch($search, $type);
if (!($result)) {
    echo "No search result found";
} else { ?>

    <div class='container'>
    <table class="table table-light table-bordered table-hover table-responsive">
    <thead>
    <th>ID</th>
    <th>Name</th>
    <th>Description</th>
    <th>Cost</th>
    <th>Type</th>
    <th>Options</th>
    </thead>
    <tbody>
    <tr>
        <?php foreach ($result

        as $row) {

        $id = $row['id'];
        $name = $row['name'];
        $description = $row['description'];
        $cost = $row['cost'];
        $type = $row['type'];
        ?>
        <td><?= $id ?></td>
        <td><?= $name ?></td>
        <td><?= $description ?></td>
        <td><?= $cost ?></td>
        <td><?= $type ?></td>
        <form action="edit_menu_item.php" method="get">
            <td>
                <button type="submit" class="btn btn-primary" name="edit" value=<?= $id ?>>Edit</button>
            </td>
        </form>
    </tr>
    <?php

}?>
    </tbody>
        </table>
    </div>
<?php }
} else {
    $result = $menu->getItems();
    ?>
    <div class='container'>
        <table class="table table-light table-bordered table-hover table-responsive">
            <thead>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Cost</th>
            <th>Type</th>
            <th>Options</th>
            </thead>
            <tbody>
            <tr>

                <?php foreach ($result

                as $row) {

                $id = $row['id'];
                $name = $row['name'];
                $description = $row['description'];
                $cost = $row['cost'];
                $type = $row['type'];

                ?>
                <td><?= $id ?></td>
                <td><?= $name ?></td>
                <td><?= $description ?></td>
                <td><?= $cost ?></td>
                <td><?= $type ?></td>
                <form action="edit_menu_item.php" method="get">
                    <td>
                        <button type="submit" class="btn btn-primary" name="edit" value=<?= $id ?>>Edit</button>
                    </td>
                </form>
            </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
<?php } ?>

    ?>


<?php include "includes/footer.php"; ?>