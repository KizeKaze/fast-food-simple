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
                } else {
                    foreach ($result as $row) {
                        echo "<div class='card'>";
                        echo "<div class='card-body'>";

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
                        echo "</div>";
                    }
                }
            } else {
                $result = $menu->getItems();

                foreach ($result as $row) {
                    echo "<div class='card'>";
                    echo "<div class='card-body'>";

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
                    <label>Type: <?= $type ?></label><br>
                    <form action="edit_menu_item.php" method="get">
                        <button type="submit" class="btn btn-primary" name="edit" value=<?= $id ?>>Edit</button>
                    </form>
                    <?php
                    echo "</div>";
                    echo "</div>";
                }
            }

            ?>
        </div>
<?php include "includes/footer.php"; ?>