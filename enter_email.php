<?php include "includes/header.php" ?>
<?php include "includes/nav.php" ?>

<?php
$query = new \App\Classes\Query();


 if (isset($_POST['reset-password'])) {
    $email = sanitize($_POST['email']);

     if(empty($email)) {
         $_SESSION['failure'] = "Your email is required";
         header('Location: enter_email.php');
         exit();
     }

     $params = [
         'email' => $email
     ];

    $result = $query->CustomSQL("SELECT email FROM users WHERE email = :email", $params);

     if (count($result) <= 0) {
         $_SESSION['failure'] = "We did not find that email in our system, sorry";
         header('Location: enter_email.php');
         exit();
     }

     $duplicate_email = $query->CustomSQL("SELECT email FROM password_resets WHERE email = :email", $params);

     if ($duplicate_email) {
        $_SESSION['failure'] = "Email has already been sent, please check your inbox or junk folder";
        header('Location: enter_email.php');
        exit();
    }

    $token = bin2hex(random_bytes(50));

    $params = [
        'email' => $email,
        'token' => $token
    ];
    $query->insert('password_resets', $params);

    $to = $email;
    $subject = "Password Reset at rayxproject.com";
     $msg = "Hi there, click on this <a href=\"http://localhost:9001/new_pass_logic.php?&token=" . $token . "\">link</a> to reset your password on our site";
    $msg = wordwrap($msg,70);
    $headers = "From: Admin@rayxproject.com";
    mail($to, $subject, $msg, $headers);

    $argument = [
        'email' => $_POST['email']
    ];

    header('location: pass_pending.php?' . http_build_query($argument));
    exit();
 }

include 'src/forms/enter_email_form.php';
