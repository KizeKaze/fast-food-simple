<?php

namespace App\Classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Password
{
    private function sendSMTP($to, $subject, $html)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = $_ENV['SMTP_HOST'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $_ENV['SMTP_USER'];
            $mail->Password   = $_ENV['SMTP_PASS'];
            $mail->SMTPSecure = $_ENV['SMTP_SECURE'];
            $mail->Port       = $_ENV['SMTP_PORT'];

            $mail->setFrom($_ENV['SMTP_USER'], 'Raywebdev');
            $mail->addAddress($to);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $html;

            return $mail->send();
        } catch (Exception $e) {
            error_log("SMTP Error: {$mail->ErrorInfo}");
            return false;
        }
    }

    public function getEmail($params)
    {
        $query = new \App\Classes\Query();
        return $query->CustomSQL(
            "SELECT email FROM password_resets WHERE token = :token AND expired_token = :expired_token LIMIT 1",
            $params
        );
    }

    public function isTokenExpired($params)
    {
        $query = new \App\Classes\Query();
        return $query->CustomSQL(
            "SELECT timed_expired_token FROM password_resets WHERE token = :token",
            $params
        );
    }

    public function updatePassword($password, $email, $token)
    {
        $query = new \App\Classes\Query();

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
        $reset_link = "https://www.raywebdev.com/new_pass_logic.php?token=" . $token;

        $msg  = "Hi there,<br><br>";
        $msg .= "Click on this <a href=\"$reset_link\">link</a> to reset your password on raywebdev.com.<br><br>";
        $msg .= "If you did not request this, you can safely ignore this email.";

        $subject = "Password Reset at Raywebdev.com";

        return $this->sendSMTP($email, $subject, $msg);
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