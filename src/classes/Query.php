<?php

namespace App\classes;

use PDO;

class Query
{
    public function CustomSQL($data = '', $bindparams = [])
    {
        $db = Database::getInstance();
        $sql = ($data);

        try {
            $stmt = $db->prepare($sql);

            foreach ($bindparams as $key => $value) {
                $stmt->bindParam($key, $value);
            }

            $stmt->execute($bindparams);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Whoops, something went wrong ahaaha');
        }
}

    public function insert($table, $parameters)
    {
        $db = Database::getInstance();

        $sql = sprintf(
            'insert into %s (%s) values (%s)',
            $table,
            implode(',', array_keys($parameters)),
            ':' . implode(', :', array_keys($parameters))
        );

        try {
            $stmt = $db->prepare($sql);
            $stmt->execute($parameters);
        } catch (Exception $e) {
            die('Whoops, something went wrong');
        }
    }

}


