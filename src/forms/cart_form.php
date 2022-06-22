<div class='container'>
    <div class="row justify-content-center">
        <div class="card col-lg-6">
        <?php
            ($cart_amount >= 1) ? include "includes/success.php" : include "includes/errors.php";
        ?>
            <div class="table-responsive">
                <table class="table table-light table-bordered table-hover table-responsive table-sm">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Cost</th>
                        <th colspan="2">Quantity</th>
                        <th>Total Cost</th>
                        <th>Options</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <?php foreach ($shoppingcart as $cart) {
                        $item_id = $cart['item_id'];
                        $id = $cart['id'];
                        $name = $cart['name'];
                        $qty = $cart['qty'];
                        $cost = $cart['cost'];
                        ?>
                        <td><?= $name ?></td>
                        <td><?= $cost ?></td>
                        <td>
                            <form action="" method="get">
                            <select class="form-select" aria-label="Quantity select" name="qty">
                                <?php $menu->showQty($qty); ?>
                            </select>
                        </td>
                            <td>
                                <input type="hidden" name="id" value="<?= $id ?>">
                                <button type="submit" class="btn btn-primary" name="update" value="<?= $item_id ?>">Update</button>
                                </form>
                            </td>
                        <td><?= ($qty * $cost) ?></td>
                        <?php
                            $total += ($qty * $cost);
                        ?>
                        <form action="" method="get">
                            <td>
                                <button type="submit" class="btn btn-danger" name="delete" value=<?= $id ?>>Delete</button>
                            </td>
                        </form>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <form action="" method="POST">
                    <div class="input-group mb-1">
                        <span class="input-group-text" id="purchase">Grand Total $</span>
                        <input class="form-control" type="text" name="grand_total" value="<?= $total ?>" readonly>
                        <button class="btn btn-success" name="purchase" <?php if ($cart_amount == 0) echo 'disabled'; ?>>Purchase</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php include "includes/footer.php"; ?>