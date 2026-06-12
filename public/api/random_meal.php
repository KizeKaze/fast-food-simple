<?php
require_once __DIR__ . '/../../php-config/init.php';

if (isset($_GET['showMeal'])) {
    $meal_array = new \App\Classes\RandomMeal();
    $meal = $meal_array->randomMeal();

    $ingredients = $meal_array->filterResult($meal, 'strIngredient');
    $measures = $meal_array->filterResult($meal, 'strMeasure');

    $filtered_i = $meal_array->cleanArray($ingredients);
    $filtered_m = $meal_array->cleanArray($measures);

    //api inconsistency. if the measure count is not the same as ingredient count, re-grab a different random meal.
    if (count($filtered_i) != count($filtered_m)) {
        header("Location: /random_meal.php?showMeal=1");
    }

    $combined = array_combine($filtered_m, $filtered_i);
}
include __DIR__ . "/../../templates/layout/header.php";
include __DIR__ . "/../../templates/layout/nav.php";
include __DIR__ . '/../../src/forms/random_meal_form.php';

