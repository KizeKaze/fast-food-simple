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
        $id_array = implode('\', \'', self::$id);
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

        $search = 'carrot';
        $type = null;

        $params = [
            'search' => $search,
            'type' => $type
        ];

        $item = self::$Menu->getItems($params);
        $this->assertNotEmpty($item);
        $this->assertArrayHasKey('name', $item[0]);

        $search = null;
        $type = 2;

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

        $item_id = 1;

        $item = self::$Menu->getItem($item_id);
        $this->assertNotEmpty($item);
        $this->assertIsArray($item);
    }

    public function testUpdateItem()
    {

        $name = 'TestLad';
        $description = 'Sometimes it do what it be';
        $cost = '1.99';
        $type_id = '9';


        $pristine_name = $name;
        $pristine_description = $description;
        $pristine_cost = $cost;
        $pristine_type_id = $type_id;

        $sql = "INSERT INTO item (name, description, cost, type_id) VALUES ('$name', '$description', '$cost', '$type_id')";
        $stmt = self::$db->prepare($sql);
        $stmt->execute();

        $inserted_id = self::$db->lastInsertId();

        self::$id[] = $inserted_id;

        $name = 'wowie';
        $description = 'Sometimes';
        $cost = '17.99';
        $type_id = '13';

        self::$Menu->updateItem($inserted_id, $name, $description, $cost, $type_id);

        $sql = "SELECT name, description, cost, type_id FROM item WHERE id = $inserted_id";
        $stmt = self::$db->prepare($sql);
        $stmt->execute();
        $filthy_results =  $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->assertNotEquals($pristine_name, $filthy_results[0]['name']);
        $this->assertNotEquals($pristine_description, $filthy_results[0]['description']);
        $this->assertNotEquals($pristine_cost, $filthy_results[0]['cost']);
        $this->assertNotEquals($pristine_type_id, $filthy_results[0]['type_id']);
    }

    public function testAddRows()
    {
        $sql = 'SELECT * FROM item ORDER BY id DESC LIMIT 1';
        $stmt = self::$db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $pristine_name = $result['name'];
        $pristine_description = $result['description'];
        $pristine_cost = $result['cost'];
        $pristine_type_id = $result['type_id'];

        $params = [
        'name' => 'addrowtest',
        'description' => 'words',
        'cost' => '170.99',
        'type' => '5'
        ];

        self::$Menu->addRows($params);

        $sql = 'SELECT * FROM item ORDER BY id DESC LIMIT 1';
        $stmt = self::$db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $id = $result['id'];
        $dirty_name = $result['name'];
        $dirty_description = $result['description'];
        $dirty_cost = $result['cost'];
        $dirty_type_id = $result['type_id'];

        $inserted_id = $id;

        $this->assertNotSame($pristine_name, $dirty_name);
        $this->assertNotSame($pristine_description, $dirty_description);
        $this->assertNotSame($pristine_cost, $dirty_cost);
        $this->assertNotSame($pristine_type_id, $dirty_type_id);
        self::$id[] = $inserted_id;
    }

    public function testShowQty()
    {
        ob_start();
        self::$Menu->showQty();
        $variable = ob_get_contents();
        ob_end_clean();

        $this->assertSame($variable, "<option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option>");

        ob_start();
        self::$Menu->showQty(1);
        $variable = ob_get_contents();
        ob_end_clean();

        $this->assertSame($variable, "<option value='1' selected='selected'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option>");
    }
}
