<?php
if (isset($_SESSION['login_message'])) {
    echo "<div class='success-container container'>";
    echo "<div class='login_message'>";
    echo $_SESSION['login_message'];
    echo "</div>";
    echo "</div>";
    $_SESSION['login_message'] = null;
}