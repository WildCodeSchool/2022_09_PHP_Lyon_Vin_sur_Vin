<?php

namespace App\Model;

class AdminManager extends AbstractManager
{
    public const TABLE = 'admin';

    public function selectOneByEmail(string $email): array|false
    {
        $statement = $this->pdo->prepare("SELECT * FROM " . static::TABLE . " WHERE email=:email");
        $statement->bindValue('email', $email, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch();
    }
    public function insert(array $credentials): int
{
    $statement = $this->pdo->prepare("INSERT INTO " . static::TABLE .
        " (`email`, `password`)
        VALUES (:email, :password)");
    $statement->bindValue(':email', $credentials['email']);
    $statement->bindValue(':password', password_hash($credentials['password'], PASSWORD_DEFAULT));
    $statement->execute();
    return (int)$this->pdo->lastInsertId();
}
}
