
<div class="container">
    <div class="row justify-content-center gx-0">
        <div class="card col-sm-12 col-md-6">
            <img class="mx-auto d-block" src="src/images/<?= $image ?>" width="75%" height="300px"
                 alt="<?= $chunk['name'] ?>">
            <div class="card-body">
                <h5 class="card-title"><?= $chunk['name'] ?></h5>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><?= $chunk['description'] ?></li>
                <li class="list-group-item">$<?= $chunk['cost'] ?> each</li>
                <?php if ($User->loggedIn()) : ?>
                <form action="" method="get">
                    <select class="add_qty form-select form-control" aria-label="Quantity select" name="qty">
                        <?php $menu->showQty(); ?>
                    </select>
            </ul>
            <div class="card-body">
                <button class="index_qty btn btn-primary" value="<?= $id ?>" type="submit" name="add">Add Item</button>
                    <a class="btn btn-danger card-link" href="/index.php">Go back</a>
                </form>
            </div>
            <?php else : ?>
            </ul>
            <div class="card-body">
                <a class="btn btn-danger card-link" href="/index.php">Go back</a>
             </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include "includes/footer.php" ?>



