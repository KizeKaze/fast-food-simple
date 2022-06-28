<?php

use App\Classes\Database;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public PDO $db;
    public $User;
    public string $email = 'testCase@gmail.com';

    public function setup(): void
    {
        $this->db = Database::getInstance();
        $this->User = new App\Classes\User();
    }

    public function tearDown(): void
    {
        $delete_sql = 'DELETE FROM users WHERE email =' . '\'' . $this->email . '\'';
        $delete_stmt = $this->db->prepare($delete_sql);
        $delete_stmt->execute();
    }

    public function testIsAdminTrue()
    {
        $_SESSION['user_role'] = 1;

        $var = $this->User->isAdmin();

        $this->assertIsBool($var);
        $this->assertTrue($var);
    }

    public function testisAdminFalse()
    {
        $_SESSION['user_role'] = 0;

        $var = $this->User->isAdmin();

        $this->assertIsBool($var);
        $this->assertFalse($var);
    }

    public function testIsLoggedIn()
    {
        $_SESSION['user_role'] = 0;
        $_SESSION['user_id'] = 1;

        $var = $this->User->loggedIn();

        $this->assertIsBool($var);
        $this->assertTrue($var);
    }

    public function testIsNotLoggedIn()
    {
        $_SESSION['user_role'] = null;
        $_SESSION['user_id'] = null;


        $var = $this->User->loggedIn();

        $this->assertIsBool($var);
        $this->assertFalse($var);
    }

    public function testinsert()
    {

        $username = 'TestCase';
        $email = 'testCase@gmail.com';
        $password = '123';

        $parameters = [
            'username' => $username,
            'email' => $email,
            'password' => $password
        ];

        $this->User->insert($parameters);

        $sql = 'SELECT email FROM users WHERE email =' . '\'' . $email . '\'';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $db_email = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertNotFalse($db_email);
        $this->assertEquals($email, $db_email['email']);
    }
}
