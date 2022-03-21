<?php include "includes/header.php"; ?>
<?php include "includes/nav.php" ?>

<?php
    $search = null;
    $type = null;

    if (isset($_POST['submit']) || isset($_POST['type'])) {
        $type = trim(htmlspecialchars($_POST['type']));
        $search = trim(htmlspecialchars($_POST['search']));
    }

    $params = [
        'search' => $search,
        'type' => $type
    ];

    $result = $menu->getItems($params);

    if (empty($result)) {
        $errors[] = "<h4>Nothing matched!</h4>";
    }
?>

    <div class="container lg">
        <div class="card">
            <div class="card-body">
                <form action="menu_list.php" method="post">
                    <select name="type" class="form-select mb-1">
                        <option value="0">All</option>
                        <?php $results = $menu->getType() ?>
                        <?php foreach ($results as $row) {
                            echo "<option value=" . $row['type_id'] . ">" . $row['type'] . "</option>";
                        } ?>
                    </select>
                    <input class="form-text" type="text" name="search" placeholder="Search...">
                    <input type="submit" name="submit" class="btn btn-primary btn-sm">
                </form>
            </div>
        </div>
    </div>
<?php
if (isset($errors)) {
    include "includes/errors.php";
} else { ?>

    <div class='container'>
        <div class="table-responsive">
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
<?php } ?>
                    <?php foreach ($result as $row) {
                        $id = $row['id'];
                        $name = $row['name'];
                        $description = $row['description'];
                        $cost = $row['cost'];
                        $type = $row['type'];
                    ?>
                    <td><?= $id ?></td>
                    <td><?= $name ?></td>
                    <td><textarea class="form-control" readonly><?=$description ?></textarea></>
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
    </div>
<?php include "includes/footer.php"; ?>