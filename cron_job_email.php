<?php
require 'vendor/autoload.php';

$email_info = new \App\Classes\Cart();
$email_object = new \App\Classes\Email;
$pass_object = new \App\Classes\Password();
use App\Classes\Database;



$db = Database::getInstance();

$query = new \App\Classes\Query();
$email_chunks = $query->CustomSQL('SELECT order_id, user_id FROM order_complete WHERE email_sent = 0');
$password_chunks = $query->CustomSQL('SELECT email, token FROM password_resets WHERE password_sent = 0');


if (!$email_chunks && !$password_chunks) {
    echo "cron job has no tasks to do, shutting down...";
   exit();
}

if ($email_chunks) {
    foreach ($email_chunks as $chunk) {
        $params = [
            'user_id' => $chunk['user_id']
        ];
        $email_array = $query->CustomSQL('SELECT email FROM users WHERE user_id = :user_id', $params);
        $email = $email_array[0]['email'];
        $order_id = $chunk['order_id'];
        $user_id = $chunk['user_id'];
        $email_items = $email_info->getUserItemsOrdered($db, $order_id, $user_id);
        $order_details = $email_info->getUserOrderDetails($db, $order_id, $user_id);


        $mail_sent = $email_object->sendEmail($email_items, $order_details, $email);
        if ($mail_sent) {
            $params = [
                'order_id' => $order_id
            ];
            $query->CustomSQL('UPDATE order_complete SET email_sent = 1 WHERE order_id = :order_id', $params);
        } else {
            echo "Failed to send email";
        }
    }
}

if ($password_chunks) {
    foreach ($password_chunks as $chunk) {
        $email = $chunk['email'];
        $token = $chunk['$token'];

        $mail_sent = $pass_object->sendPassword($email, $token);

        if ($mail_sent) {
            echo "password reset sent";

            $params = [
                'email' => $chunk['email'],
                'token' => $chunk['token']
            ];
            $query->CustomSQL('UPDATE password_resets SET password_sent = 1 WHERE email = :email AND token = :token', $params);
        } else {
            echo "Failed to sent password reset";
        }
    }
}
