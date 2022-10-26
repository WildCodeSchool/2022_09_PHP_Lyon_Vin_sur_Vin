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
}
