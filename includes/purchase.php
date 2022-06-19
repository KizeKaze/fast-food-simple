<?php
if (isset($_SESSION['purchase'])) {
    echo "<div class='success-container container'>";
    echo "<div class='item_added'>";
    echo $_SESSION['purchase'];
    echo "</div>";
    echo "</div>";
    $_SESSION['purchase'] = null;
}