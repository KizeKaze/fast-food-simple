<?php

namespace App\Classes;

use Exception;

class Email
{
    public function sendEmail($email_items, $order_details, $email)
    {
        $user_email = $email;
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom("raywebdev@outlook.com");
        $email->setSubject("Receipt From Raywebdev.com");
        $email->addTo($user_email);
        ob_start();

        include 'src/forms/email_items_form.php';
        $msg = ob_get_contents();
        ob_end_clean();
        $msg = wordwrap($msg,70);
        $email->addContent("text/html", $msg);

        $send_grid = new \SendGrid($_ENV['SENDGRID_API_KEY']);
        try {
            $response = $send_grid->send($email);
            return $response->statusCode() == 202;
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }
    }
}
