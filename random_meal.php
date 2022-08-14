<?php include "includes/header.php" ?>
<?php include "includes/nav.php" ?>

<?php

if (isset($_GET['showMeal'])) {
    $meal_array = new \App\Classes\RandomMeal();
    $meal = $meal_array->randomMeal();
}

include 'src/forms/random_meal_form.php';
