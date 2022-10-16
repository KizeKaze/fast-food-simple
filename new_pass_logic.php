<?php include "includes/header.php" ?>
<?php include "includes/nav.php"; ?>
<?php

if (isset($_POST['new_password'])) {

    $query = new \App\Classes\Query();

    $password = sanitize($_POST['password']);
    $confirm_password = sanitize($_POST['confirm_password']);
    $token = sanitize($_GET['token']);

    $params = [
        'token' => $token,
        'expired_token' => 0
    ];
    $email = $query->CustomSQL("SELECT email FROM password_resets WHERE token = :token AND expired_token = :expired_token LIMIT 1", $params);

    $exp_date = date("Y-m-d h:i:s");
    $params = [
        'token' => $token
    ];

    $exp_token = $query->CustomSQL("SELECT timed_expired_token FROM password_resets WHERE token = :token", $params);

    if (empty($password)) {
        $errors[] = "Please enter a password";
    } else if (empty($confirm_password)) {
        $errors[] = "Please confirm your password";
    } else if ($password != $confirm_password) {
        $errors[] = "Passwords did not match";
    } else if (empty($exp_token)) {
        $errors[] = "Invalid Token, please click <a href='enter_email.php'>here</a> to try again";
    } else if (empty($email[0]['email'])) {
        $errors[] = "Invalid Token, please click <a href='enter_email.php'>here</a> to try again";
    }

    if (!empty($exp_token)) {
        if ($exp_date > $exp_token[0]['timed_expired_token']) {
            $errors[] = "Invalid Token, please click <a href='enter_email.php'>here</a> to try again";
        }
    }

    if(empty($errors)) {
        if (isset($email[0]['email'])) {
            $new_password = password_hash($password, PASSWORD_DEFAULT);
            $params = [
                'password' => $new_password,
                'email' => $email[0]['email']
            ];
            $query->CustomSQL('UPDATE users SET password = :password WHERE email = :email', $params);

            $params = [
                'token' => $token,
                'expired_token' => 1
            ];
            $query->CustomSQL('UPDATE password_resets SET expired_token = :expired_token WHERE token = :token', $params);
            $item_added = "Password reset, you can <a href='login.php'>login</a> now";

        } else {
            $errors[] = "Invalid Token, please click <a href='enter_email.php'>here</a> to try again";
        }
    }
}
//assign token here if user has not yet clicked new_password
$token = sanitize($_GET['token']);

include 'src/forms/new_pass_form.php';
