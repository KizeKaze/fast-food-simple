<?php


use App\Classes\Database;
use PHPUnit\Framework\TestCase;

class QueryTest extends TestCase
{

    public static PDO $db;
    public static $Query;
    public static array $id = [];

    public static function setUpBeforeClass(): void
    {
        self::$db = Database::getInstance();
        self::$Query = new App\Classes\Query();
    }

    public static function tearDownAfterClass(): void
    {
        $id_array = implode('\', \'', self::$id);
        $delete_sql = 'DELETE FROM users WHERE user_id IN(' . '\'' . $id_array . '\')';
        $delete_stmt = self::$db->prepare($delete_sql);
        $delete_stmt->execute();
    }

    public function testCustomSQL()
    {

        $sql = 'SELECT MAX(user_id)  from users';
        $stmt = self::$db->prepare($sql);
        $stmt->execute();
        $pristine_result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $username = 'test';
        $email = 'testemail@email.com';
        $password = '123';

        $param = [
          'username' => $username,
          'email' => $email,
          'password' => $password
        ];
        self::$Query->CustomSQL('INSERT INTO users (username, email, password) VALUES (:username, :email, :password)', $param);

        $sql = 'SELECT MAX(user_id) AS id  from users';
        $stmt = self::$db->prepare($sql);
        $stmt->execute();
        $inserted_id = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertNotSame($pristine_result, $inserted_id);

        self::$id[] = $inserted_id['id'];

    }

    public function testInsert()
    {
        $sql = 'SELECT MAX(user_id)  from users';
        $stmt = self::$db->prepare($sql);
        $stmt->execute();
        $pristine_result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $username = 'inserttest';
        $email = 'inserttestemail@email.com';
        $password = 'insert123';

        $param = [
            'username' => $username,
            'email' => $email,
            'password' => $password
        ];
        self::$Query->insert('users', $param);

        $sql = 'SELECT MAX(user_id) AS id  from users';
        $stmt = self::$db->prepare($sql);
        $stmt->execute();
        $inserted_id = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertNotSame($pristine_result, $inserted_id);

       self::$id[] = $inserted_id['id'];

    }
}
