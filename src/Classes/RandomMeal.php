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

         return $decoded = $decoded['meals'][0];
    }
}