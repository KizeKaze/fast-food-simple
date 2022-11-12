<?php

namespace App\Classes;


class Password
{

    public function checkEmail($params)
    {
        $query = $query = new \App\Classes\Query();

        return $query->CustomSQL("SELECT email FROM password_resets WHERE token = :token AND expired_token = :expired_token LIMIT 1", $params);
    }

    public function checkToken($params)
    {
        $query = $query = new \App\Classes\Query();

        return $query->CustomSQL("SELECT timed_expired_token FROM password_resets WHERE token = :token", $params);
    }

    public function updatePassword($password, $email, $token)
    {
        $query = $query = new \App\Classes\Query();

        $new_password = password_hash($password, PASSWORD_DEFAULT);
        $params = [
            'password' => $new_password,
            'email' => $email
        ];
        $query->CustomSQL('UPDATE users SET password = :password WHERE email = :email', $params);

        $params = [
            'token' => $token,
            'expired_token' => 1
        ];
        $query->CustomSQL('UPDATE password_resets SET expired_token = :expired_token WHERE token = :token', $params);
        return "Password reset, you can <a href='login.php'>login</a> now";

    }
}