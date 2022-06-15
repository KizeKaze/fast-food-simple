<?php

namespace App\classes;

class User
{
    private string $username = '';
    private string $email = '';
    private string $password = '';
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


}