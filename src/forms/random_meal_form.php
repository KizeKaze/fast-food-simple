<div class="container">
    <div class="row justify-content-center">
        <div class="card col-sm-6">
            <div class="card">
                <div class="card-header">
                    Hungry?
                </div>
                <div class="card-body">
                    <h5 class="card-title">Don't know what to eat?..</h5>
                    <p class="card-text">With this sweet meal api at our fingertips, generating meal recipes has never been easier.</p>
                    <a href="/random_meal.php?showMeal=1" class="btn btn-primary">Show me the light</a>
                </div>
            </div>
            <?php if (isset($meal)) : ?>
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?= $meal['strMeal']; ?></h5>
                    <ul>
                        <?php $chunks = explode('.', $meal['strInstructions']); ?>
                        <?php foreach ($chunks as $element) : ?>
                            <?php if ($element && trim(strlen($element)) > 4) : ?>
                           <li><?= $element ?></li>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>


<?php include "includes/footer.php"; ?>