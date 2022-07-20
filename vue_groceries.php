<?php
require 'vendor/autoload.php';






header('Content-Type: application/json');

$query = new \App\classes\Query();

// INNER JOIN THIS BITCH TO GET TYPES RAY, EZ
$lists = $query->CustomSQL('SELECT * FROM item i 
                    INNER JOIN type t ON i.type_id = t.type_id');

echo json_encode($lists);

