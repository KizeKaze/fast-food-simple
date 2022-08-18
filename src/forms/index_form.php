<div class="container lg">
    <div class="card mb-3 mt-3">
        <div class="well">
            <h3>Hey, I have recently integrated an API into the project, interested? <a href="/random_meal.php">Click Here</a></h3>
        </div>
    </div>
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

<div class='container' id="main_card">
    <div class="table-responsive">
        <table class="table table-light table-bordered table-hover table-responsive">
            <thead>
            <?php if ($User->isAdmin()) : ?>
                <th>ID</th>
            <?php endif; ?>
            <th>Name</th>
            <th class="screen_size">Description</th>
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
                <td class="screen_size"><textarea class="form-control" readonly><?=$description ?></textarea></td>
                <td><?= $cost ?></td>
                <td><?= $type ?></td>
                <?php if ($User->isAdmin()) : ?>
                        <td>
                            <a class="btn btn-primary" href="../../edit_menu_item.php?edit=<?= $id ?>">Edit</a>
                        </td>
                    <form action="../../index.php" method="get">
                        <td>
                            <button type="submit" class="index_delete btn btn-danger" name="delete" value="<?= $id ?>">Delete</button>
                        </td>
                    </form>
                    <form action="" method="get">
                        <td>
                            <select class="add_qty form-select" aria-label="Quantity select" name="qty">
                                <?php  $menu->showQty(); ?>
                            </select>
                        </td>
                        <td>

                            <button class="index_qty btn btn-primary" value="<?= $id ?>" type="submit">Add</button>
                        </td>
                    </form>
                <?php elseif ($User->loggedIn()) :  ?>
                    <form action="" method="get">
                        <td>
                            <select class="add_qty form-select" aria-label="Quantity select" name="qty">
                                <?php $menu->showQty(); ?>
                            </select>
                        </td>
                        <td>
                            <button class="index_qty btn btn-primary" value="<?= $id ?>" type="submit">Add</button>
                        </td>
                    </form>
                <?php endif; ?>
            </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<script src="src/js/index.js"></script>
<?php include "includes/footer.php"; ?>