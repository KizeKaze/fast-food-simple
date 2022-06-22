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
            <?php include "includes/success.php"; ?>
            <?php include "includes/purchase.php"; ?>
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
            <?php if ($User->isAdmin()) : ?>
                <th>ID</th>
            <?php endif; ?>
            <th>Name</th>
            <th>Description</th>
            <th>Cost</th>
            <th>Type</th>
            <?php if ($User->isAdmin()) : ?>
                <th colspan="2">Options</th>
                <th>Quantity</th>
                <th>Cart</th>
            <?php elseif ($User->loggedIn()) : ?>
                <th>Quantity</th>
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
                <?php if ($User->isAdmin()) : ?>
                    <td><?= $id ?></td>
                <?php endif; ?>
                <td><?= $name ?></td>
                <td><textarea class="form-control" readonly><?=$description ?></textarea></td>
                <td><?= $cost ?></td>
                <td><?= $type ?></td>
                <?php if ($User->isAdmin()) : ?>
                    <form action="../../edit_menu_item.php" method="get">
                        <td>
                            <button type="submit" class="btn btn-primary" name="edit" value=<?= $id ?>>Edit</button>
                        </td>
                    </form>
                    <form action="../../index.php" method="get">
                        <td>
                            <button type="submit" class="btn btn-danger" name="delete" value=<?= $id ?>>Delete</button>
                        </td>
                    </form>
                    <form action="" method="get">
                        <td>
                            <select class="form-select" aria-label="Quantity select" name="qty">
                                <?php $menu->showQty($qty); ?>
                            </select>
                        </td>
                        <td>
                            <button class="btn btn-primary" name="add" value="<?= $id ?>">Add</button>
                        </td>
                    </form>
                <?php elseif ($User->loggedIn()) :  ?>
                    <form action="" method="get">
                        <td>
                            <select class="form-select" aria-label="Quantity select" name="qty">
                                <?php $menu->showQty($qty); ?>
                            </select>
                        </td>
                        <td>
                            <button class="btn btn-primary" name="add" value="<?= $id ?>">Add</button>
                        </td>
                    </form>
                <?php endif; ?>
            </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php include "includes/footer.php"; ?>