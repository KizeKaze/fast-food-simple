<?php

namespace App\Classes;


class Password
{

    public function getEmail($params)
    {
        $query = $query = new \App\Classes\Query();

        return $query->CustomSQL("SELECT email FROM password_resets WHERE token = :token AND expired_token = :expired_token LIMIT 1", $params);
    }

    public function isTokenExpired($params)
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

    public function sendPassword($email, $token) {
        $to = $email;
        $subject = "Password Reset at rayxproject.com";

        $headers = "From: Admin@rayxproject.com" . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        $msg = "Hi there, click on this <a href=\"http://www.rayxproject.com/new_pass_logic.php?token=" . $token . "\">link</a> to reset your password on rayxproject.com";
        $msg = wordwrap($msg,70);
        return mail($to, $subject, $msg, $headers);
    }

    public function pendingEmail() {
        if (!$_GET['email']) {
            $_SESSION['failure'] = "What are you doing..";
            header('Location: enter_email.php');
            exit();
        }
    }
}