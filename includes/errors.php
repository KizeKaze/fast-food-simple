<?php

    if (isset($errors)) {
        echo "<div class='error-container container w-50'>";
        foreach ($errors as $error) {
            echo "<div class='error'>";
            echo $error;
            echo "</div>";
        }
        echo "</div>";
    }


