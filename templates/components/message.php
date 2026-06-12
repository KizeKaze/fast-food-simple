<?php
if (isset($_SESSION['message'])) {
    echo "<div class='success-container container'>";
    echo "<div class='item_added'>";
    echo $_SESSION['message'];
    echo "</div>";
    echo "</div>";
    $_SESSION['message'] = null;
}