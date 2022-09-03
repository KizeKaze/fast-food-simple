
<?php

$name = $chunk['name'];
$image = $chunk['image'];

?>


<div class="container">
    <div class="row justify-content-center gx-0">
        <div class="card col-sm-12 col-md-6">
            <img class="mx-auto d-block" src="src/images/<?= $image ?>" width="300px" height="300px" alt="<?= $chunk['name'] ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= $chunk['name'] ?></h5>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><?= $chunk['description'] ?></li>
                    <li class="list-group-item">$<?= $chunk['cost'] ?> each</li>
                </ul>
                <div class="card-body">
                    <a href="#" class="card-link">Card link</a>
                    <a href="#" class="card-link">Another link</a>
                </div>
        </div>
    </div>
</div>

<?php include "includes/footer.php" ?>



