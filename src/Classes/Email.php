<?php

namespace App\Classes;

use Exception;

class Email
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
    public function sendEmail($email_items, $order_details, $email)
    {
        $user_email = $email;

        ob_start();
        // Hard path to this file for raywebdev.com
        include '/var/www/html/src/forms/email_items_form.php';
        $msg = ob_get_contents();
        ob_end_clean();

        $msg = wordwrap($msg,70);

        $subject = "Receipt From Raywebdev.com";

        return $this->sendSMTP($user_email, $subject, $msg);
    }
}
