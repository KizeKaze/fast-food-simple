<?php


use App\Classes\Database;
use PHPUnit\Framework\TestCase;

class MenuTest extends TestCase
{
    public static PDO $db;
    public static $Menu;
    public static array $id = [];

    public static function setUpBeforeClass(): void
    {
        self::$db = Database::getInstance();
        self::$Menu = new App\Classes\Menu();
    }

    public static function tearDownAfterClass(): void
    {
        $id_array = implode(', ', self::$id);
        $delete_sql = 'DELETE FROM item WHERE id IN(' . '\'' . $id_array . '\')';
        $delete_stmt = self::$db->prepare($delete_sql);
        $delete_stmt->execute();
    }

    public function testGetTypes()
    {
        $type = self::$Menu->getTypes();

        $this->assertNotEmpty($type);
        $this->assertIsArray($type);
    }

    public function testGetItemsWithSearch()
    {

        $search = 'Apple';
        $type = null;

        $params = [
            'search' => $search,
            'type' => $type
        ];

        $item = self::$Menu->getItems($params);
        $this->assertNotEmpty($item);
        $this->assertArrayHasKey('name', $item[0]);

        $search = null;
        $type = 11;

        $params = [
            'search' => $search,
            'type' => $type
        ];

        $item = self::$Menu->getItems($params);
        $this->assertNotEmpty($item);
        $this->assertArrayHasKey('type_id', $item[0]);
    }

    public function testGetItem()
    {

        $item_id = 206;

        $item = self::$Menu->getItem($item_id);
        $this->assertNotEmpty($item);
        $this->assertIsArray($item);
    }

    public function testUpdateItem()
    {

        $sql = 'SELECT MAX(id) AS item_id FROM item';
        $stmt = self::$db->prepare($sql);
        $stmt->execute();
        $pristine_results =  $stmt->fetchAll(PDO::FETCH_ASSOC);

        $name = 'TestLad';
        $description = 'Sometimes it do what it be';
        $cost = '1.99';
        $type_id = '11';
        $pristine_name = $name;

        $sql = "INSERT INTO item (name, description, cost, type_id) VALUES ('$name', '$description', '$cost', '$type_id')";
        $stmt = self::$db->prepare($sql);
        $stmt->execute();

        $inserted_id = self::$db->lastInsertId();

        $this->assertNotEquals($pristine_results, $inserted_id);

        self::$id[] = $inserted_id;

        $name = 'wowie';
        $description = 'Sometimes';
        $cost = '17.99';
        $type_id = '13';

        self::$Menu->updateItem($inserted_id, $name, $description, $cost, $type_id);

        $sql = "SELECT name FROM item WHERE id = $inserted_id";
        $stmt = self::$db->prepare($sql);
        $stmt->execute();
        $filthy_results =  $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->assertNotEquals($name, $filthy_results);
    }
}
