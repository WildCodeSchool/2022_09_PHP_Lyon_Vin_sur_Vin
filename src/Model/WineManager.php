<?php

namespace App\Model;

use PDO;
use App\Controller\AbstractController;

class WineManager extends AbstractManager
{
    public const TABLE = 'wine';

    public function selectOneWineById(int $id): array|false
    {
        // prepared request
        $statement = $this->pdo->prepare('SELECT w.id as id, name, year, price, region, color, grape, partner_id,
        w.description, p.lastname as lastname, p.firstname as firstname FROM ' . static::TABLE .
            ' as w INNER JOIN partner as p ON p.id = w.partner_id WHERE w.id=:id');
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

    public function insert(array $wine): int
    {
        $query = "INSERT INTO " . self::TABLE .
            " (`name`, `year`, `price`, `partner_id`, `color`, `region`, `grape`, `image`, `description`, `favorite`)
        VALUES (:name, :year, :price, :partner_id, :color, :region, :grape, :image, :description, 0)";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':name', $wine['name'], \PDO::PARAM_STR);
        $statement->bindValue(':year', $wine['year'], \PDO::PARAM_INT);
        $statement->bindValue(':price', $wine['price'], \PDO::PARAM_STR);
        $statement->bindValue(':partner_id', $wine['partner_id'], \PDO::PARAM_INT);
        $statement->bindValue(':color', $wine['color'], \PDO::PARAM_STR);
        $statement->bindValue(':region', $wine['region'], \PDO::PARAM_STR);
        $statement->bindValue(':grape', $wine['grape'], \PDO::PARAM_STR);
        $statement->bindValue(':image', $wine['image'], \PDO::PARAM_STR);
        $statement->bindValue(':description', $wine['description'], \PDO::PARAM_STR);
        $statement->execute();

        return (int)$this->pdo->lastInsertId();
    }
    public function update(array $wine): bool
    {
        $query = "UPDATE " . self::TABLE . " SET `name` = :name, `year` = :year, `price` = :price,
        `partner_id` = :partner_id, `color` = :color, `region` = :region,
        `grape`= :grape, `image` = :image, `description`= :description WHERE id=:id";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('id', $wine['id'], \PDO::PARAM_INT);
        $statement->bindValue('name', $wine['name'], \PDO::PARAM_STR);
        $statement->bindValue('year', $wine['year'], \PDO::PARAM_INT);
        $statement->bindValue('price', strval($wine['price']), \PDO::PARAM_STR);
        $statement->bindValue('partner_id', $wine['partner_id'], \PDO::PARAM_INT);
        $statement->bindValue('color', $wine['color'], \PDO::PARAM_STR);
        $statement->bindValue('region', $wine['region'], \PDO::PARAM_STR);
        $statement->bindValue('grape', $wine['grape'], \PDO::PARAM_STR);
        $statement->bindValue(':image', $wine['image'], \PDO::PARAM_STR);
        $statement->bindValue('description', $wine['description'], \PDO::PARAM_STR);
        return $statement->execute();
    }

    public function selectFavorites(): array
    {
        $query = 'SELECT * FROM ' . static::TABLE . ' WHERE favorite = true';

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

    public function selectWinesFromPartner(int $id): array
    {
        $id = $_SESSION['pro_id'];

        $query = 'SELECT * FROM ' . static::TABLE . ' WHERE partner_id =' . $id;


        return $this->pdo->query($query)->fetchAll();
    }

    public function selectSearch(string $search): array
    {

        $statement = $this->pdo->prepare("SELECT name, year, price, region, color, grape, w.image,
         p.firstname, p.lastname FROM "
            . static::TABLE . " as w LEFT JOIN partner as p ON p.id = w.partner_id
        WHERE name LIKE :search
        OR year LIKE  :search
        OR price LIKE :search
        OR region LIKE :search
        OR color LIKE :search
        OR grape LIKE :search
        OR p.firstname LIKE :search
        OR p.lastname LIKE :search
        OR w.description LIKE :search");
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

    public function getAllWithPartner(): array
    {
        $statement = $this->pdo->prepare('SELECT p.firstname, p.lastname, p.address,
         p.email, p.phone, p.image as partner_image, p.description as partner_description,
         w.id, w.name, w.year, w.price, w.color, w.region, w.grape, w.image, w.partner_id, w.description
        FROM ' . self::TABLE . ' AS w INNER JOIN partner as p ON p.id = w.partner_id ORDER BY w.name ASC');
        $statement->execute();

        return $statement->fetchAll();
    }
}
