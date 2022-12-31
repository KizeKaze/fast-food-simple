<?php

namespace App\Classes;

class Email
{
    public function sendEmail($email_items, $order_details)
    {
        $i = 1;

        $to = $_SESSION['email'];
        $subject = "Receipt From rayxproject.com";

        $headers = "From: Admin@rayxproject.com" . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        ob_start();
        include 'src/forms/email_items_form.php';
        $msg = ob_get_contents();
        ob_end_clean();
        $msg = wordwrap($msg,70);
        mail($to, $subject, $msg, $headers);
    }
}