<?php

namespace App\Model;

use PDO;

class WineManager extends AbstractManager
{
    public const TABLE = 'wine';

    public function insert(array $wine): int
    {
        $query = "INSERT INTO " . self::TABLE .
            " (`name`, `year`, `price`, `partner_id`, `description`, `favorite`)
        VALUES (:name, :year, :price, :partner_id, :description, 0)";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':name', $wine['name'], \PDO::PARAM_STR);
        $statement->bindValue(':year', $wine['year'], \PDO::PARAM_INT);
        $statement->bindValue(':price', $wine['price'], \PDO::PARAM_INT);
        $statement->bindValue(':partner_id', $wine['partner_id'], \PDO::PARAM_INT);
        $statement->bindValue(':description', $wine['description'], \PDO::PARAM_STR);
        $statement->execute();

        return (int)$this->pdo->lastInsertId();
    }
    public function update(array $wine): bool
    {
        $query = "UPDATE " . self::TABLE . " SET `name` = :name, `year` = :year, `price` = :price,
        `partner_id` = :partner_id, `description`= :description WHERE id=:id";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('id', $wine['id'], \PDO::PARAM_INT);
        $statement->bindValue('name', $wine['name'], \PDO::PARAM_STR);
        $statement->bindValue('year', $wine['year'], \PDO::PARAM_INT);
        $statement->bindValue('price', $wine['price'], \PDO::PARAM_INT);
        $statement->bindValue('partner_id', $wine['partner_id'], \PDO::PARAM_INT);
        $statement->bindValue('description', $wine['description'], \PDO::PARAM_STR);
        return $statement->execute();
    }

    public function selectFavorites(): array
    {
        $query = 'SELECT id, name, year, price, description FROM ' . static::TABLE . ' WHERE favorite = true';

        return $this->pdo->query($query)->fetchAll();
    }

    public function addFavorite(int $id): void
    {
        // prepared request
        $statement = $this->pdo->prepare("UPDATE " . static::TABLE . " SET favorite = 1 WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }

    public function deleteFavorite(int $id): void
    {
        // prepared request
        $statement = $this->pdo->prepare("UPDATE " . static::TABLE . " SET favorite = 0 WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }

    public function checkIfFavorite(int $id): array|false
    {
        // prepared request
        $statement = $this->pdo->prepare('SELECT favorite FROM ' . static::TABLE . ' WHERE id=:id');
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

    public function selectPartner(): array
    {
        $query = 'SELECT id, lastname, firstname FROM partner ';

        return $this->pdo->query($query)->fetchAll();
    }

    public function selectSearch(string $search): array
    {

        $statement = $this->pdo->prepare("SELECT * FROM " . static::TABLE . " WHERE name 
        LIKE :search
        OR year LIKE  :search
        OR category LIKE :search
        OR price LIKE :search
        OR description LIKE :search");
        $statement->bindValue('search', '%' . $search . '%', \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function selectOneByEmail(string $email): array|false
    {
        $statement = $this->pdo->prepare("SELECT * FROM " . static::TABLE . " WHERE email=:email");
        $statement->bindValue('email', $email, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch();
    }
}
