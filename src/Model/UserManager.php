<?php

namespace App\Model;

use PDO;

class UserManager extends AbstractManager
{
    public const TABLE = 'user';

    public function selectOneByEmail(string $email): array|false
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM " . static::TABLE . " WHERE email=:email");
        $statement->bindValue(':email', $email, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch();
    }

    public function insert(array $credentials): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . static::TABLE .
            " (`email`, `password`, `pseudo`, `firstname`, `lastname`, `address`, `phone`)
        VALUES (:email, :password, :pseudo, :firstname, :lastname, :address, :phone)");
        $statement->bindValue(':email', $credentials['email'], PDO::PARAM_STR);
        $statement->bindValue(':password', password_hash($credentials['password'], PASSWORD_DEFAULT));
        $statement->bindValue(':pseudo', $credentials['pseudo'], PDO::PARAM_STR);
        $statement->bindValue(':firstname', $credentials['firstname'], PDO::PARAM_STR);
        $statement->bindValue(':lastname', $credentials['lastname'], PDO::PARAM_STR);
        $statement->bindValue(':address', $credentials['address'], PDO::PARAM_STR);
        $statement->bindValue(':phone', $credentials['phone'], PDO::PARAM_STR);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
}
