<?php include "includes/header.php" ?>
<?php include "includes/nav.php"; ?>
<?php

if (isset($_POST['new_password'])) {

    $query = new \App\Classes\Query();
    $pass_object = new \App\Classes\Password();

    $password = sanitize($_POST['password']);
    $confirm_password = sanitize($_POST['confirm_password']);
    $token = sanitize($_GET['token']);


    $params = [
        'token' => $token,
        'expired_token' => 0
    ];
    $email = $pass_object->getEmail($params);

    $exp_date = date("Y-m-d h:i:s");
    $params = [
        'token' => $token
    ];

    $expired_token_date = $pass_object->isTokenExpired($params);

    if (empty($password)) {
        $errors[] = "Please enter a password";
    } else if (empty($confirm_password)) {
        $errors[] = "Please confirm your password";
    } else if ($password != $confirm_password) {
        $errors[] = "Passwords did not match";
    } else if (empty($expired_token_date)) {
        $errors[] = "Invalid Token, please click <a href='enter_email.php'>here</a> to resend another token to a valid email";
    } else if (empty($email[0]['email'])) {
        $errors[] = "Invalid Token, please click <a href='enter_email.php'>here</a> to resend another token to a valid email";
    }

    if (!empty($expired_token_date)) {
        if ($exp_date > $expired_token_date[0]['timed_expired_token']) {
            $errors[] = "Invalid Token, please click <a href='enter_email.php'>here</a> to resend another token to a valid email";
        }
    }

    if(empty($errors)) {
        if (isset($email[0]['email'])) {
           $item_added = $pass_object->updatePassword($password, $email[0]['email'], $token);
        } else {
            $errors[] = "Invalid Token, please click <a href='enter_email.php'>here</a> to resend another token to a valid email";
        }
    }
}
//assign token here if user has not yet clicked new_password
$token = $_GET['token'] ?? '';
$token = sanitize($_GET['token']);

include 'src/forms/new_pass_form.php';
