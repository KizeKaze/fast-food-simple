<?php

namespace App\Classes;


use Exception;

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

    public function sendPassword($email, $token)
    {
        $user_email = $email;
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom("raywebdev@outlook.com");
        $email->setSubject("Password Reset at Raywebdev.com");
        $email->addTo($user_email);
        $msg = "Hi there, click on this <a href=\"https://www.raywebdev.com/new_pass_logic.php?token=" . $token . "\">link</a> to reset your password on raywebdev.com";
        $msg = wordwrap($msg,70);
        $email->addContent("text/html", $msg);

        $send_grid = new \SendGrid($_ENV['SENDGRID_API_KEY']);
        try {
            $response = $send_grid->send($email);
            return $response->statusCode() == 202;
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
            return false;
        }

    }

    public function pendingEmail()
    {
        if (!$_GET['email']) {
            $_SESSION['failure'] = "What are you doing..";
            header('Location: enter_email.php');
            exit();
        }
    }
}