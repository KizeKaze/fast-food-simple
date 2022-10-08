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

    echo "if you made it here, you are passed the email validation";


 }






include 'src/forms/enter_email_form.php';
