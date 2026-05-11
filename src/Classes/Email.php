<?php

namespace App\Classes;

use Exception;

class Email
{
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

        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
        $headers .= "From: raywebdev@outlook.com\r\n";

        return mail($user_email, $subject, $msg, $headers);
    }
}
