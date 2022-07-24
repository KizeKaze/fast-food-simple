<?php

namespace App\Classes;

class User
{
    private string $username = '';
    private string $email = '';
    private string $password = '';
    private string $today = '';
    private int $user_role = 0;

    public function __construct() {}

    public function getUsername() : string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {

        $this->username = $username;
    }

    public function getDate() : string
    {
        return $this->date;
    }

    public function setDate(string $date): void
    {

        $this->date = $date;
    }

    public function getEmail() : string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {

        $this->email = $email;
    }

    public function getPassword() : string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {

        $this->password = $password;
    }

    public function getUserrole() : int
    {
        return $this->user_role;
    }
    public function setUserrole(int $user_role): void
    {
        $this->user_role = $user_role;
    }

    public function insert($parameters)
    {

        $query = new \App\Classes\Query();

        $query->insert('users', $parameters);

    }

    public function isAdmin()
    {
        if(isset($_SESSION['user_role'])) {
            return $_SESSION['user_role'] == 1;
        }
        return false;
    }

    public function loggedIn() {
        if (isset($_SESSION['user_role'])) {
            return $_SESSION['user_id'] == true;
        }
        return false;
    }
}