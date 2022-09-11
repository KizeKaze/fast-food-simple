<?php
if (isset($_SESSION['failure'])) {
    echo "<div class='error-container container'>";
    echo "<div class='error'>";
    echo $_SESSION['failure'];
    echo "</div>";
    echo "</div>";
    $_SESSION['failure'] = null;
}