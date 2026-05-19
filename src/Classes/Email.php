<?php

namespace App\Classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Resend;

class Email
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
    public function sendEmail($email_items, $order_details, $email): bool
    {
        $user_email = $email;

        ob_start();
        // Hard path to this file for raywebdev.com
        include __DIR__ . '/../forms/email_items_form.php';
        $msg = ob_get_contents();
        ob_end_clean();

        $msg = wordwrap($msg,70);

        $subject = "Receipt From Raywebdev.com";

        //replace with sendSMTP for localhost testing
        return $this->sendResend($user_email, $subject, $msg);
    }
}
