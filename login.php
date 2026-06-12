<?php

require_once __DIR__ . '/php-config/init.php';

if($_POST) {
    $query = new \App\Classes\Query();

    $email = sanitize($_POST['email']);
    $password = sanitize($_POST['password']);

    if (empty($email)) {
        $errors[] = 'Invalid email';
    }

    if (empty($password)) {
        $errors[] = 'Invalid password';
    }

    if (!isset($errors)) {

        $params = [
            'email' => $email
        ];

        //grab email and hashed password to compare to user entered info
        $result = $query->CustomSQL('SELECT * FROM users WHERE email = :email', $params );

        if ($result) {
            $db_email = $result[0]['email'];
            $db_password = $result[0]['password'];

            $verified_pass = password_verify($password, $db_password);

            if ($email !== $db_email || $verified_pass != true) {
                $errors[] = 'Email or Password not found';
            } else {
                $_SESSION['user_id'] = $result[0]['user_id'];
                $_SESSION['username'] = $result[0]['username'];
                $_SESSION['email'] = $result[0]['email'];
                $_SESSION['user_role'] = $result[0]['user_role'];

                $_SESSION['login_message'] = "Welcome, " . $_SESSION['username'];

                header("Location: index.php");
                exit();
            }
        } else {
            $errors[] = 'Email or Password not found';
        }
    }
}
include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/nav.php';
include __DIR__ . '/src/forms/login_form.php';



