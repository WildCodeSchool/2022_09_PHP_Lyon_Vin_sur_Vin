<?php

namespace App\Model;

use PDO;

class PartnerManager extends AbstractManager
{
    public const TABLE = 'partner';

    public function insert(array $partner): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . "
         (`firstname`, `lastname`, `address`, `email`, `phone`, `description` ) 
        VALUES (:firstname, :lastname, :address, :email, :phone, :description)");
        $statement->bindValue('firstname', $partner['firstname'], PDO::PARAM_STR);
        $statement->bindValue('lastname', $partner['lastname'], PDO::PARAM_STR);
        $statement->bindValue('address', $partner['address'], PDO::PARAM_STR);
        $statement->bindValue('email', $partner['email'], PDO::PARAM_STR);
        $statement->bindValue('phone', $partner['phone'], PDO::PARAM_STR);
        $statement->bindValue('description', $partner['description'], PDO::PARAM_STR);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function update(array $partner): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `firstname` = :firstname,
        `lastname` = :lastname, `address` = :address, `email` = :email, `phone` = :phone,
        `description` = :description WHERE id=:id");
        $statement->bindValue('id', $partner['id'], PDO::PARAM_INT);
        $statement->bindValue('firstname', $partner['firstname'], PDO::PARAM_STR);
        $statement->bindValue('lastname', $partner['lastname'], PDO::PARAM_STR);
        $statement->bindValue('address', $partner['address'], PDO::PARAM_STR);
        $statement->bindValue('email', $partner['email'], PDO::PARAM_STR);
        $statement->bindValue('phone', $partner['phone'], PDO::PARAM_STR);
        $statement->bindValue('description', $partner['description'], PDO::PARAM_STR);

        return $statement->execute();
    }
}
