<div class="container lg">
    <div class="card">
        <div class="card-body">
            <form action="../../index.php" method="post">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="input-group mb-1">
                                <input class="form-control" type="text" name="search" placeholder="Search...">
                                <input type="submit" name="submit" class="btn btn-primary btn-sm">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="input-group mb-1">
                                <span class="input-group-text" id="inputGroup-sizing-default">Search By Type</span>
                                <select name="type" class="form-select form-select">
                                    <option value="0">All</option>
                                    <?php $results = $menu->getType() ?>
                                    <?php foreach ($results as $row) {
                                        echo "<option value=" . $row['type_id'] . ">" . $row['type'] . "</option>";
                                    } ?>
                                </select>
                                <input type="submit" name="submit" class="btn btn-primary btn-sm">
                            </div>
                        </div>
                    </div>
                </div>
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
            <?php if ($_SESSION['user_role'] == 1) : ?>
                <th>ID</th>
            <?php endif; ?>
            <th>Name</th>
            <th>Description</th>
            <th>Cost</th>
            <th>Type</th>
            <th>Quantity</th>
            <?php if ($_SESSION['user_role'] == 1) : ?>
                <th colspan="2">Options</th>
            <?php else : ?>
                <th>Cart</th>
            <?php endif; ?>
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
                <?php if ($_SESSION['user_role'] == 1) : ?>
                    <td><?= $id ?></td>
                <?php endif; ?>
                <td><?= $name ?></td>
                <td><textarea class="form-control" readonly><?=$description ?></textarea></td>
                <td><?= $cost ?></td>
                <td><?= $type ?></td>
                <td>
                    <select class="form-select" aria-label="Quantity select">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </td>
                <?php if($_SESSION['user_role'] == 1) : ?>
                    <form action="../../edit_menu_item.php" method="get">
                        <td>
                            <button type="submit" class="btn btn-primary" name="edit" value=<?= $id ?>>Edit</button>
                        </td>
                    </form>
                    <form action="../../index.php" method="get">
                        <td>
                            <button type="submit" class="btn btn-primary" name="delete" value=<?= $id ?>>Delete</button>
                        </td>
                    </form>
                <?php elseif ($_SESSION['user_role'] == 0) :  ?>
                    <td>
                        <button class="btn btn-primary">Add</button>
                    </td>
                <?php endif; ?>
            </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php include "includes/footer.php"; ?>