<?php

namespace App\Classes;

class RandomMeal
{

    public function randomMeal(): array
    {
        $ch = curl_init();
        $url = "https://www.themealdb.com/api/json/v1/1/random.php";

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        if($e = curl_error($ch)) {
            echo $e;
        } else {
            $decoded = json_decode($response, true);
        }

        curl_close($ch);

        return $decoded['meals'][0];
    }

    public function filterResult($array, $string): array
    {
        $filtered_array = [];

        foreach ($array as $key => $value) {
            if (str_contains($key, $string)) {
                $filtered_array[] = $value;
            }
        }
        return $filtered_array;
    }

    public function cleanArray($data): array
    {
        return array_filter($data, function ($element){
            return is_string($element) && '' !== trim($element);
        });
    }
}