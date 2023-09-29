<?php

use App\Classes\Database;
use PHPUnit\Framework\TestCase;

class PasswordTest extends TestCase
{

    public static PDO $db;
    public static $Password_Obj;
    public static $Query;
    public static array $id= [];

    public static function setUpBeforeClass(): void
    {
        self::$db = Database::getInstance();
        self::$Password_Obj = new \App\Classes\Password();
        self::$Query = new App\Classes\Query();
    }

    public static function tearDownAfterClass(): void
    {
        $id_array = implode('\', \'', self::$id);
        $delete_sql = 'DELETE FROM users WHERE user_id IN(' . '\'' . $id_array . '\')';
        $delete_stmt = self::$db->prepare($delete_sql);
        $delete_stmt->execute();
    }

    public function testGetEmail()
    {

        $email = 'somelongfakeemailnooneshouldeverhaveevertobehonestyouknowwhatimeanorwhatyooldemail@someemailserverthingorwhatever.com';
        $params = [
            'token' => '123123',
            'expired_token' => 0
        ];

        $expected_result = [];

        $result = self::$Password_Obj->getEmail($params);

        $this->assertEquals($expected_result, $result);

        $params = [
            'email' => $email,
            'token' => '8675309',
            'expired_token' => 0,
            'timed_expired_token' => '2023-09-27 05:31:07'
        ];

        self::$Query->insert('password_resets', $params);

        $params = [
            'token' => '8675309',
            'expired_token' => 0
        ];

        $second_result = self::$Password_Obj->getEmail($params);

        $second_expected_result = [
            'email' => 'somelongfakeemailnooneshouldeverhaveevertobehonestyouknowwhatimeanorwhatyooldemail@someemailserverthingorwhatever.com'
        ];
        $this->assertIsArray($second_result);
        $this->assertSame($second_expected_result, $second_result[0]);

        $params = [
        'email' => $email
        ];

        self::$Query->CustomSQL('DELETE FROM password_resets WHERE email = :email', $params);
    }

    public function testIsTokenInvalid()
    {

        $params = [
            'token' => '123123'
        ];

        $expected_result = [];

        $result = self::$Password_Obj->isTokenExpired($params);

        $this->assertEquals($expected_result, $result);
    }

    public function testUpdatePassword()
    {
        $inserted_password = password_hash('123', PASSWORD_DEFAULT);

        $params = [
            'username' => 'testuser',
            'email' => 'fakeemail@email.com',
            'password' => $inserted_password,
            'user_role' => 0
        ];

        self::$Query->insert('users', $params);

        $params = [
            'email' => 'fakeemail@email.com',
            'token' => 111,
            'expired_token' => 0
        ];

        self::$Query->insert('password_resets', $params);

        $inserted_id = self::$Query->CustomSQL('SELECT MAX(user_id) as user_id FROM users');

        $id = $inserted_id[0]['user_id'];
        self::$id[] = $id;

        $params = [
            'user_id' => $id
        ];

        $email = 'fakeemail@email.com';
        $token = '111';

        self::$Password_Obj->updatePassword('321', $email, $token);

        $test_inserted_data = self::$Query->CustomSQL('SELECT * FROM users WHERE user_id = :user_id', $params);

        $db_password = $test_inserted_data[0]['password'];

        $this->assertNotSame($inserted_password, $db_password);

        $inserted_token = 0;
        $params = [
            'token' => $token
        ];
        $returned_data = self::$Query->CustomSQL('SELECT * FROM password_resets WHERE token = :token', $params);

        $this->assertNotSame($inserted_token, $returned_data);

        $params = [
            'id' => $returned_data[0]['id']
        ];

        self::$Query->CustomSQL('DELETE FROM password_resets WHERE id = :id', $params);
    }
}
