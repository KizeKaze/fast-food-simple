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
        $cost = $param['cost'];
        $type = $param['type'];

        $stmt = $db->prepare("INSERT INTO item (name, description, cost, type_id) VALUES (:name, :description, :money, :type)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':money', $cost);
        $stmt->bindParam(':type', $type);
        $stmt->execute();


    }

    public function getType(): array
    {
        $db = Database::getInstance();

        $sql = "SELECT type_id, type FROM type";

        $stmt = $db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function checkType()
    {
        $db = Database::getInstance();

        $sql = "SELECT type_id FROM type";
        $stmt = $db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_COLUMN);


    }
}
