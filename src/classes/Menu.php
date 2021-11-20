<?php

namespace App\Classes;

use PDO;

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
    public function addRows($param)
    {
        $db = Database::getInstance();

        $name = $param['name'];
        $description = $param['description'];
        $money = $param['cashMONEY'];

        $stmt = $db->prepare("INSERT INTO item (name, description, cost, type_id) VALUES (:name, :description, :money, 1)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':money', $money);
        $stmt->execute();


    }
}
