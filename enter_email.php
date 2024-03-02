<?php include "includes/header.php" ?>
<?php include "includes/nav.php" ?>

<?php
$query = new \App\Classes\Query();
$pass_object = new \App\Classes\Password();


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

    $token = bin2hex(random_bytes(50));
    $exp_date = date("Y-m-d h:i:s", strtotime("+ 1 day"));

    $params = [
        'email' => $email,
        'token' => $token,
        'timed_expired_token' => $exp_date
    ];
    $query->insert('password_resets', $params);

    //This is when password gets fired off
    $pass_object->sendPassword($email, $token);

    $argument = [
        'email' => $_POST['email']
    ];

    header('location: pass_pending.php?' . http_build_query($argument));
    exit();
 }

include 'src/forms/enter_email_form.php';
