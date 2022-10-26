<?php

namespace App\Model;

use PDO;

class WineManager extends AbstractManager
{
    public const TABLE = 'wine';

    public function update(array $item): bool
    {
        $query = "UPDATE " . self::TABLE . " SET `name` = :name, `year` = :year, `price` = :price,
        `partner_id` = :partner_id, `description`= :description WHERE id=:id";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':name', $wine['name'], \PDO::PARAM_STR);
        $statement->bindValue(':year', $wine['year'], \PDO::PARAM_INT);
        $statement->bindValue(':price', $wine['price'], \PDO::PARAM_INT);
        $statement->bindValue(':partner_id', $wine['partner_id'], \PDO::PARAM_INT);
        $statement->bindValue(':description', $wine['description'], \PDO::PARAM_STR);

        return $statement->execute();
    }
}
