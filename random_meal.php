<?php include "includes/header.php" ?>
<?php include "includes/nav.php" ?>

<?php

if (isset($_GET['showMeal'])) {
    $meal_array = new \App\Classes\RandomMeal();
    $meal = $meal_array->randomMeal();

    $ingredients = $meal_array->filterResult($meal, 'strIngredient');
    $measures = $meal_array->filterResult($meal, 'strMeasure');

    $filtered_i = array_filter($ingredients, function ($element){
        return is_string($element) && '' !== trim($element);
    });

    $filtered_m = array_filter($measures, function ($element){
        return is_string($element) && '' !== trim($element);
    });

    $combined = array_combine($filtered_m, $filtered_i);
}

include 'src/forms/random_meal_form.php';
