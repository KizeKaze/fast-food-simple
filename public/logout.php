<?php
session_start();
$_SESSION['username'] = null;
$_SESSION['user_id'] = null;
$_SESSION['email'] = null;
$_SESSION['user_role'] = null;

header("Location: index.php");
exit();
