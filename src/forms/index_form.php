<div class="container lg">
    <div class="card mb-3 mt-3">
        <div class="card-body">
            <h5 class="card-title">Project Summary</h5>
            <p class="card-text">Hey thanks for checking my project out. This project allows Users to grocery shop and Admins to manage the items and grocery shop.</p>
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <strong>User Features</strong>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Add items to your personal cart</li>
                                <li class="list-group-item">Two different ways to search for items</li>
                                <li class="list-group-item">Update quantities in personal cart</li>
                                <li class="list-group-item">Remove items from personal cart</li>
                                <li class="list-group-item">Purchase items in your personal cart*<br>("Purchased" items are logged into the database along with the user purchasing the items, price and date.)</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <strong>Admin Features</strong>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">All User Features</li>
                                <li class="list-group-item">Add/Edit/Delete Items</li>
                                <li class="list-group-item">Add/Edit/Delete Types</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <p>I have also integrated an API <a href="/random_meal.php">here</a> and use Vue to add new items for Users and Admins <a href="/src/forms/vue_groceries_form.php">here</a></p>
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
            <?php include "includes/failure.php"; ?>
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
                <th class="hide_mobile_large">ID</th>
            <?php endif; ?>
            <th>Name</th>
            <th class="hide_mobile_large">Description</th>
            <th>Cost</th>
            <th class="hide_mobile_large">Type</th>
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
                    <td class="hide_mobile_large"><?= $id ?></td>
                <?php endif; ?>
                <td><a href="../../show_item_details.php?item=<?= $id ?>" class="text-decoration-none"><?= $name ?></a></td>
                <td class="hide_mobile_large"><textarea class="form-control" readonly><?=$description ?></textarea></td>
                <td><?= $cost ?></td>
                <td class="hide_mobile_large"><?= $type ?></td>
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