<div class='container'>
    <div class="row justify-content-center">
        <div class="card col-md-6">

                <?php
                include "includes/success.php";
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
                                <?php if (isset($qty)) : ?>
                                    <option value="<?= $qty ?>"><?= $qty ?></option>
                                <?php endif; ?>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
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
                    <?php if (isset($errors)) : ?>
                        <?php include "includes/errors.php"; ?>
                    <?php else : ?>
                <form action="" method="POST">
                    <div class="input-group mb-1">
                        <span class="input-group-text" id="purchase">Grand Total $</span>
                        <input class="form-control" type="text" name="grand_total" value="<?= $total ?>" readonly>
                        <button class="btn btn-success" name="purchase">Purchase</button>
                    </div>
                </form>
                    <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<?php include "includes/footer.php"; ?>