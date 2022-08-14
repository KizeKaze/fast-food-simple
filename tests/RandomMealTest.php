<?php

use App\Classes\RandomMeal;
use PHPUnit\Framework\TestCase;

class RandomMealTest extends TestCase
{

    public static $meal;
    public array $array = [];

    public static function setUpBeforeClass(): void
    {
        self::$meal = new RandomMeal();
    }

    public function testRandomMeal()
    {
        $random_meal = self::$meal->randomMeal();

        $this->assertNotEmpty($random_meal);
        $this->assertIsArray($random_meal);
    }

    public function testFilterResult()
    {
        $array = [
            'test' => 'wowow11',
            '1234' => 'wowow22',
            '1235' => 'wwweeeeww33',
            'shieesh' => 'wowow44',
            'wwwqqq' => 'wowow55',
        ];

        $random_meal = self::$meal->filterResult($array, '123');

        $this->assertNotEmpty($random_meal);
        $this->assertIsArray($random_meal);
    }

    public function testCleanArray()
    {
        $array = [
          '0' => '',
          '1' => '',
          '2' => 'test',
          '3' => 'woah',
          '4' => 'yes',
        ];

        $random_meal = self::$meal->cleanArray($array);
        $this->assertIsArray($random_meal);
        $this->assertNotSame($array, $random_meal);
    }
}
