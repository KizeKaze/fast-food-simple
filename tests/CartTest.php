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

        $order_id_array = implode('\', \'', self::$id);
        $delete_order_sql = 'DELETE FROM order_item WHERE user_id IN(' . '\'' . $order_id_array . '\')';
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


        $db = Database::getinstance();

        $params = [
            'user_id' => -4,
            'grand_total' => '10.99'
        ];

        self::$Cart->insertOrderComplete($params);

        $params = ['user_id' => -4];

        $prestine_fake_user_order_id = self::$Query->CustomSQL('SELECT order_id FROM order_complete WHERE user_id = :user_id', $params);

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

    public function testCartPurchaseComplete()
    {

        $params = [
            'user_id' => -6,
            'grand_total' => '79.22'
        ];

        self::$Cart->insertOrderComplete($params);

        $params = [
            'item_id' => 7,
            'user_id' => -6,
            'qty' => 2
        ];

        self::$Cart->insertCart($params);
        $params = ['user_id' => -6];
        self::$Cart->cartPurchaseCompleted($params);

        $current_order_id = self::$Query->CustomSQL('SELECT MAX(order_id) as order_id FROM order_item WHERE user_id = :user_id', $params);

        $params = [
            'user_id' => -6,
            'grand_total' => '253.23'
        ];

        self::$Cart->insertOrderComplete($params);

        $params = [
            'item_id' => 13,
            'user_id' => -6,
            'qty' => 4
        ];

        self::$Cart->insertCart($params);
        $params = ['user_id' => -6];
        self::$Cart->cartPurchaseCompleted($params);

        $new_order_id = self::$Query->CustomSQL('SELECT MAX(order_id) as order_id FROM order_item WHERE user_id = :user_id', $params);

        self::$Cart->cartPurchaseCompleted($params);

        $this->assertnotsame($current_order_id, $new_order_id);
        $this->assertIsArray($new_order_id);

        $inserted_id = -6;
        self::$id[] = $inserted_id;
    }

    public function testGetUserItemOrdered()
    {

        $params = [
            'user_id' => -7,
            'grand_total' => '765.43'
        ];

        self::$Cart->insertOrderComplete($params);

        $params = [
            'item_id' => 6,
            'user_id' => -7,
            'qty' => 1
        ];

        self::$Cart->insertCart($params);
        $params = ['user_id' => -7];
        self::$Cart->cartPurchaseCompleted($params);
        $order_id = self::$Query->CustomSQL('SELECT MAX(order_id) as order_id FROM order_item WHERE user_id = :user_id', $params);

        $params = [
            'order_id' => $order_id[0]['order_id'],
            'user_id' => -7
        ];
        $inserted_order_items = self::$Query->CustomSQL('SELECT * FROM order_item WHERE order_id = :order_id' . ' AND user_id = :user_id', $params);

        $expected_array = [
            'order_id' => $order_id[0]['order_id'],
            'user_id' => -7,
            'item_id' => 6,
            'item_name' => 'Eggs',
            'cost' => '0.99',
            'qty' => 1
        ];

        $this->assertNotEmpty($inserted_order_items);
        $this->assertIsArray($inserted_order_items);
        $this->assertSame($expected_array, $inserted_order_items[0]);

        $inserted_id = -7;
        self::$id[] = $inserted_id;
    }

    public function testGetUsedOrderDetails()
    {
        $params = [
            'user_id' => -8,
            'grand_total' => '14.59'
        ];
        self::$Cart->insertOrderComplete($params);

        $params = [ 'user_id' => -8 ];
        $order_id = self::$Query->CustomSQL('SELECT MAX(order_id) as order_id FROM order_complete WHERE user_id = :user_id', $params);

        $params = [
            'order_id' => $order_id[0]['order_id'],
            'user_id' => -8
        ];
        $current_db_order = self::$Query->CustomSQL('SELECT * FROM order_complete WHERE order_id = :order_id' . ' AND user_id = :user_id', $params);

        $expected_db_order = [
            'order_id' => $order_id[0]['order_id'],
            'user_id' => -8,
            'date_purchased' => $current_db_order[0]['date_purchased'],
            'grand_total' => '14.59'
        ];

        $this->assertNotEmpty($current_db_order);
        $this->assertSame($expected_db_order, $current_db_order[0]);

        $inserted_id = -8;
        self::$id[] = $inserted_id;

    }

    public function testInsertOrderComplete()
    {
        $params = [
                'user_id' => -9,
                'grand_total' => '0.50'
            ];
        self::$Cart->insertOrderComplete($params);

        $params = [ 'user_id' => -9 ];
        $order_id = self::$Query->CustomSQL('SELECT MAX(order_id) as order_id FROM order_complete WHERE user_id = :user_id', $params);

        $params = [
            'order_id' => $order_id[0]['order_id'],
            'user_id' => -9
        ];
        $current_db_order = self::$Query->CustomSQL('SELECT * FROM order_complete WHERE order_id = :order_id' . ' AND user_id = :user_id', $params);

        $expected_result = [
            'order_id' => $order_id[0]['order_id'],
            'user_id' => -9,
            'date_purchased' => $current_db_order[0]['date_purchased'],
            'grand_total' => '0.50'
        ];

        $this->assertNotEmpty($current_db_order[0]);
        $this->assertSame($expected_result, $current_db_order[0]);

        $inserted_id = -9;
        self::$id[] = $inserted_id;
    }

}
