<?php

namespace App\Classes;

use PDO;

class Menu
{

    public function getTypes(): array
    {
        $db = Database::getInstance();

        $sql = "SELECT * FROM type";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function getItems($params): array
    {
        $search = $params['search'];
        $type = $params['type'];

        $db = Database::getInstance();

        $sql = "SELECT * FROM item i 
                    INNER JOIN type t ON i.type_id = t.type_id WHERE 1 = 1";

        if ($search) {
            $sql.= " AND name like :search";
            $search = "%" . $search . "%";
        }
        if ($type > 0){
            $sql.= " AND t.type_id like :type";
        }

        $stmt = $db->prepare($sql);

        if ($search){
            $stmt->bindValue(':search', $search);
        }
        if($type > 0) {
            $stmt->bindParam(':type', $type);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getItem($item_id): array
    {
        $db = Database::getInstance();

        $sql = "SELECT * FROM item i 
                    INNER JOIN type t ON i.type_id = t.type_id WHERE id = :item_id";

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':item_id', $item_id);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateItem($id, $name, $description, $cost, $type): void
    {
    $db = Database::getInstance();

    $sql = "UPDATE item SET name = :name, description = :description, cost = :cost, type_id = :type_id WHERE id = :id";

    $stmt = $db->prepare($sql);

    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':cost', $cost);
    $stmt->bindParam(':type_id', $type);
    $stmt->bindParam(':id', $id);

    $stmt->execute();

    }

    public function addRows($param)
    {
        $db = Database::getInstance();

        $name = $param['name'];
        $description = $param['description'];
        $cost = $param['cost'];
        $type = $param['type'];
        $image = $param['image'];

        $stmt = $db->prepare("INSERT INTO item (name, description, cost, type_id, image) VALUES (:name, :description, :money, :type, :image)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':money', $cost);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':image', $image);
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
    public function showQty($qty = 0)
    {
        for ($i = 1; $i <= 5; $i++) {
            echo "<option value='$i'";
            echo ($qty == $i) ? " selected='selected'" : "";
            echo ">" . $i . "</option>";
        }
    }
}
