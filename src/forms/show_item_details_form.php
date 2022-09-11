<div class="container">
    <div class="row justify-content-center gx-0">
        <div class="card col-sm-12 col-md-6">
            <form action="" method="get">
                <img class="mx-auto d-block" src="src/images/<?= $image ?>" width="75%" height="300px" alt="<?= $chunk['name'] ?>">
                <div class="card-body">
                <hr>
                <h5 class="card-title"><?= $chunk['name'] ?></h5>
                <hr>
                <p class="card-text"><?= $chunk['description'] ?></p>
                <hr>
                <p class="card-text">$<?= $chunk['cost'] ?> each</p>
                <hr>
                <?php if ($User->loggedIn()) : ?>
                <select class="add_qty form-select" aria-label="Quantity select" name="qty">
                    <?php $menu->showQty(); ?>
                </select>
                <div class="card-body">
                    <button class="index_qty btn btn-primary" value="<?= $id ?>" type="submit" name="add">Add Item
                    </button>
                    <a class="btn btn-danger card-link" href="/index.php">Go back</a>
                </div>
            </form>
            <?php else : ?>
            <div class="card-body">
                <a class="btn btn-danger card-link" href="/index.php">Go back</a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include "includes/footer.php" ?>
