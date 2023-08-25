<?php
session_start();


use App\Classes\Database;
use PHPUnit\Framework\TestCase;

class CartTest extends TestCase
{
    public static PDO $db;
    public static $Cart;
    public static $Query;
    public static array $id = [];
    public static array $static_order_id = [];

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

        $order_id_array = implode('\', \'', self::$id);
        $delete_order_sql = 'DELETE FROM order_complete WHERE user_id IN(' . '\'' . $order_id_array . '\')';
        $delete_stmt = self::$db->prepare($delete_order_sql);
        $delete_stmt->execute();
    }

    public function testCheckCart() {

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

    public function testUpdateCart()
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

    public function testInsertCart()
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



    public function testGetMaxOrderID()
    {
        $_SESSION['user_id'] = -4;

        //Change order_complete


        $db = Database::getinstance();

        $params = [
            'user_id' => -4,
            'grand_total' => '10.99'
        ];

        //REPLACE these inserts with insertOrderComplete to test the function in the CART CLASS, this is just hand testing.
        //only queries I should be writing in a integration test should to validate database contents.

        //create a current order for fake user to compare to a new created user


        self::$Cart->insertOrderComplete($params);

        $params = ['user_id' => -4];

        $prestine_fake_user_order_id = self::$Query->CustomSQL('SELECT * FROM order_complete WHERE user_id = :user_id', $params);

        //oh look the same user just bought some more stuff!
        $params = [
            'user_id' => -4,
            'grand_total' => '54.99'
        ];

        self::$Cart->insertOrderComplete($params);

        $params = ['user_id' => -4];

        $max_order_id = self::$Cart->getMaxOrderID($db);

        $user_id = -4;

        $this->assertNotSame($prestine_fake_user_order_id, $max_order_id);

        $inserted_id = -4;
        self::$id[] = $inserted_id;

    }

    public function testUserItemOrdered()
    {
        $max_order_id = self::$static_order_id;
        //dd($max_order_id, 1);
    }


}
