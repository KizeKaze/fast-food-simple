<?php

    if (isset($errors)) {
        echo "<div class='error-container container'>";
        foreach ($errors as $error) {
            echo "<div class='error'>";
            echo $error;
            echo "</div>";
        }
        echo "</div>";
    }

