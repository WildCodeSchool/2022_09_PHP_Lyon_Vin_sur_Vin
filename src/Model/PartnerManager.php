<?php

namespace App\Model;

use PDO;

class PartnerManager extends AbstractManager
{
    public const TABLE = 'partner';

    public function selectOneByEmail(string $email): array|false
    {
        $statement = $this->pdo->prepare("SELECT * FROM " . static::TABLE . " WHERE email=:email");
        $statement->bindValue('email', $email, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch();
    }

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

    public function addPassword(array $credentials)
    {
        $statement = $this->pdo->prepare("UPDATE " . static::TABLE .
            " SET `password` = :password WHERE email=:email");
        $statement->bindValue(':email', $credentials['email']);
        $statement->bindValue(':password', password_hash($credentials['password'], PASSWORD_DEFAULT));
        $statement->execute();
    }

    public function getWinesByPartner(int $id): array
    {
        $statement = $this->pdo->prepare('SELECT p.firstname, p.lastname, p.address,
        p.email, p.phone, p.image as partner_image, p.description as partner_description,
        w.id, w.name, w.year, w.price, w.color, w.region, w.grape, w.image, w.partner_id, w.description
       FROM wine AS w INNER JOIN partner as p ON p.id = w.partner_id WHERE p.id=:id ORDER BY w.name ASC');
        $statement->bindValue('id', $id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }
}
