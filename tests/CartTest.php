<?php


use App\Classes\Database;
use PHPUnit\Framework\TestCase;

class CartTest extends TestCase
{
    public static PDO $db;
    public static $Cart;
    public static $Query;
    public static array $id = [];

    public static function setUpBeforeClass(): void
    {
        self::$db = Database::getInstance();
        self::$Query = new \App\Classes\Query();
        self::$Cart = new App\Classes\Cart();
    }

    public static function tearDownAfterClass(): void
    {
        $id_array = implode('\', \'', self::$id);
        $delete_sql = 'DELETE FROM cart WHERE user_id IN(' . '\'' . $id_array . '\')';
        $delete_stmt = self::$db->prepare($delete_sql);
        $delete_stmt->execute();
    }

    function testCheckCart() {

        $params = [
            'item_id' => -100,
            'user_id' => -1
        ];

        $expected_result = [

        ];

       $first_cart = self::$Cart->checkCart($params);

       $this->assertEquals($expected_result, $first_cart);

       $params = [
           'item_id' => -1,
           'user_id' => -1,
           'qty' => 2
       ];

       self::$Query->insert('cart', $params);

       $inserted_id = -1;

       self::$id[] = $inserted_id;

        $params = [
            'item_id' => -1,
            'user_id' => -1,
        ];

       $second_cart = self::$Cart->checkCart($params);

       $expected_result = [
         'item_id' => -1,
         'user_id' => -1,
         'qty' => 2
       ];

       $this->assertEquals($expected_result, $second_cart[0]);

    }

    function testUpdateCart()
    {

        $params = [
            'item_id' => -2,
            'user_id' => -2,
            'qty' => 1
        ];
        self::$Query->insert('cart', $params);

        $params = [
            'item_id' => -2,
            'user_id' => -2,
            'qty' => 4
        ];
        $result = self::$Cart->updateCart($params);

        $expected_result = [
            'item_id' => -2,
            'user_id' => -2,
            'qty' => 4
        ];

        $this->assertNotSame($expected_result, $result);

        $inserted_id = -2;
        self::$id[] = $inserted_id;

    }

    function testInsertCart()
    {
        $params = [
            'item_id' => -3,
            'user_id' => -3,
            'qty' => 3
        ];

        self::$Query->insert('cart', $params);

        $params = [
            'item_id' => -3,
            'user_id' => -3,
        ];

        $result = self::$Cart->checkCart($params);

        $expected_result = [
            'user_id' => -3,
            'item_id' => -3,
            'qty' => 3
        ];

        $this->assertSame($expected_result, $result[0]);

        $inserted_id = -3;
        self::$id[] = $inserted_id;
    }
}
