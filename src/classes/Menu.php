<?php

namespace App\Classes;

class Menu
{
    public function getItems(): array
    {
        $database = Database::getInstance();
        
        $sql = "SELECT * FROM item i
                    INNER JOIN type t ON i.type_id = t.type_id";
        
        $statement = $database->prepare($sql);
        $statement->execute();
    
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
}
