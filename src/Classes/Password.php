<?php

namespace App\Classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Resend;

class Password
{
    // Sends email using SMTP for localhost testing
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

    // Sends email using Resend
    private function sendResend($to, $subject, $html): bool
    {
        try {
            $resend = Resend::client($_ENV['RESEND_API_KEY']);
            
            $result = $resend->emails->send([
                'from' => $_ENV['RESEND_FROM_EMAIL'],
                'to' => $to,
                'subject' => $subject,
                'html' => $html,
            ]);

            return isset($result['id']);
        } catch (Exception $e) {
            error_log("Resend Error: {$e->getMessage()}");
            return false;
        }
    }

    // Returns email from password_resets table
    public function getEmail($params): array
    {
        $query = new \App\Classes\Query();
        return $query->CustomSQL(
            "SELECT email FROM password_resets WHERE token = :token AND expired_token = :expired_token LIMIT 1",
            $params
        );
    }

    // Returns token from password_resets table
    public function isTokenExpired($params): array
    {
        $query = new \App\Classes\Query();
        return $query->CustomSQL(
            "SELECT timed_expired_token FROM password_resets WHERE token = :token",
            $params
        );
    }

    // Updates password and expired_token in password_resets table
    public function updatePassword($password, $email, $token): string
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

    // Sends password reset email
    public function sendPassword($email, $token): bool
    {
        $reset_link = "https://www.raywebdev.com/new_pass_logic.php?token=" . $token;

        $msg  = "Hi there,<br><br>";
        $msg .= "Click on this <a href=\"$reset_link\">link</a> to reset your password on raywebdev.com.<br><br>";
        $msg .= "If you did not request this, you can safely ignore this email.";

        $subject = "Password Reset at Raywebdev.com";

        //replace with sendSMTP for localhost testing
        return $this->sendResend($email, $subject, $msg);
    }

    // Redirects to enter_email.php if no email is provided
    public function pendingEmail(): void
    {
        if (!$_GET['email']) {
            $_SESSION['failure'] = "What are you doing..";
            header('Location: enter_email.php');
            exit();
        }
    }
}