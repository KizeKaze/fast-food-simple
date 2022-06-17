<?php include "includes/header.php" ?>
<?php include "includes/nav.php" ?>

<?php

if($_POST) {
    $username = sanitize($_POST['username']);
    $email = sanitize($_POST['email']);
    $password = sanitize($_POST['password']);
    $confirm_password = sanitize($_POST['confirm_password']);

    if(empty($username)) {
        $errors[] = 'Please enter a username';
    }

    if(empty($email)) {
        $errors[] = 'Please enter a email';
    }

    if(empty($password)) {
        $errors[] = 'Please enter a password';
    }

    if(empty($confirm_password)) {
        $errors[] = 'Please confirm your password';
    }

    if($password != $confirm_password) {
        $errors[] = 'Passwords do not match';
    }

    if (!isset($errors)) {
        $new_password = password_hash($password, PASSWORD_DEFAULT);

        $User = new \App\Classes\User();

        $User->setUsername($username);
        $User->setEmail($email);
        $User->setPassword($new_password);

        $param = [
            'username' => $User->getUsername(),
            'email' => $User->getEmail(),
            'password' => $User->getPassword()
        ];

        $User->insert($param);

        $item_added = 'Account created!';
    }
}
include 'src/forms/register_form.php';
?>
