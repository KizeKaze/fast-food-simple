<?php
//Added these so my IDE stops complaining about undefined variables
/** @var \App\Classes\Menu $menu */
/** @var \App\Classes\User $User */
/** @var array $result */
?>
<div class="container lg">
    <div class="card">
        <div class="card-body">
            <form action="../../index.php" method="post">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="input-group mb-1">
                                <label for="search_text" class="visually-hidden">
                                    Search by Text
                                </label>
                                <input id="search_text" class="form-control" type="text" name="search" placeholder="Search...">
                                <input type="submit" name="submit" class="btn btn-primary btn-sm" aria-label="Search by text">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="input-group mb-1">
                                <label for="search_select" class="visually-hidden">
                                    Search by Select
                                </label>
                                <span class="input-group-text" id="inputGroup-sizing-default">Search By Type</span>
                                <select id="search_select" name="type" class="form-select form-select">
                                    <option value="0">All</option>
                                    <?php $results = $menu->getType() ?>
                                    <?php foreach ($results as $row) {
                                        echo "<option value=" . $row['type_id'] . ">" . $row['type'] . "</option>";
                                    } ?>
                                </select>
                                <input type="submit" name="submit" class="btn btn-primary btn-sm" aria-label="Search by type">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <?php include __DIR__ ."/../../includes/success.php"; ?>
            <?php include __DIR__ ."/../../includes/message.php"; ?>
            <?php include __DIR__ ."/../../includes/failure.php"; ?>
        </div>
    </div>
</div>
<?php
if (isset($errors)) {
    include __DIR__ ."/../../includes/errors.php";
} else { ?>

<div class='container' id="main_card">
    <div class="table-responsive">
        <table class="table table-light table-bordered table-hover table-responsive">
            <thead>
            <tr>
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
            </tr>
            </thead>

            <tbody>
            <?php foreach ($result as $row) : ?>
                <tr>
                    <?php if ($User->isAdmin()) : ?>
                        <td class="hide_mobile_large"><?= $row['id'] ?></td>
                    <?php endif; ?>

                    <td>
                        <a href="../../show_item_details.php?item=<?= $row['id'] ?>" class="text-decoration-none">
                            <?= $row['name'] ?>
                        </a>
                    </td>

                    <td class="hide_mobile_large">
                        <label for="description<?= $row['id'] ?>" class="visually-hidden">
                            Description
                        </label>
                        <textarea id="description<?= $row['id'] ?>" class="form-control" readonly><?= $row['description'] ?></textarea>
                    </td>

                    <td><?= $row['cost'] ?></td>
                    <td class="hide_mobile_large"><?= $row['type'] ?></td>

                    <?php if ($User->isAdmin()) : ?>
                        <td>
                            <a class="btn btn-primary" href="../../edit_menu_item.php?edit=<?= $row['id'] ?>">Edit</a>
                        </td>

                        <td>
                            <form action="../../index.php" method="get">
                                <button type="submit" class="index_delete btn btn-danger" name="delete" value="<?= $row['id'] ?>">
                                    Delete
                                </button>
                            </form>
                        </td>

                        <td>
                            <form action="" method="get">
                                <label for="qty_<?= $row['id'] ?>" class="visually-hidden">
                                    Quantity
                                </label>
                                <select id="qty_<?= $row['id'] ?>" class="add_qty form-select" name="qty">
                                    <?php $menu->showQty(); ?>
                                </select>

                                <button class="index_qty btn btn-primary" value="<?= $row['id'] ?>" type="submit">
                                    Add
                                </button>
                            </form>
                        </td>

                    <?php elseif ($User->loggedIn()) : ?>

                        <td>
                            <form action="" method="get">
                                <label for="qty_<?= $row['id'] ?>" class="visually-hidden">
                                    Quantity
                                </label>
                                <select id="qty_<?= $row['id'] ?>" class="add_qty form-select" name="qty">
                                    <?php $menu->showQty(); ?>
                                </select>

                                <button class="index_qty btn btn-primary" value="<?= $row['id'] ?>" type="submit">
                                    Add
                                </button>
                            </form>
                        </td>

                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php } ?>
    </div>
</div>
<script src="/src/js/index.js"></script>
<?php include __DIR__ ."/../../includes/footer.php"; ?>