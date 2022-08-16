<div class="container lg">
    <div class="row justify-content-center">
        <div class="card col-sm-12 col-md-6">
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
                <h5 class="card-title text-center"><?= $meal['strMeal']; ?></h5>
                <img class="card-img-top" src="<?= $meal['strMealThumb']; ?>" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">Ingredients You Will Need</h5>
                    <ul>
                       <?php foreach ($combined as $key => $value) : ?>
                            <li><?="$key" . " - " . "$value"; ?></li>
                       <?php endforeach; ?>
                    </ul>
                    <h5 class="card-title">Cooking Instructions</h5>
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
            <div class="card">
                <h5 class="card-title">Want to follow a YouTube how to?</h5>
                <div class="card-body">
                    <a class="btn btn-primary" target="@" href="<?= $meal['strYoutube']; ?>"><?= $meal['strMeal']; ?></a>
                    <a class="btn btn-secondary" href="#top">Back To Top</a>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>


<?php include "includes/footer.php"; ?>