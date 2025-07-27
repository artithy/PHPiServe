<?php


namespace App\classes;

use App\Database;
use PDO;


class Cuisine extends Database
{
    private $pdo;

    public function __construct()
    {
        $db = new Database();
        $this->pdo = $db->connect();
    }

    public function createTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS cuisine (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL
        )";

        return $this->pdo->exec($sql);
    }

    public function create($name)
    {
        $stmt = $this->pdo->prepare("INSERT INTO cuisine (name) VALUES (:name)");
        return $stmt->execute(['name' => $name]);
    }

    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM cuisine ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id, $name)
    {
        $stmt = $this->pdo->prepare("UPDATE cuisine SET name= :name WHERE id= :id");
        return $stmt->execute(['id' => $id, 'name' => $name]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE from cuisine WHERE id= :id");
        return $stmt->execute(['id' => $id]);
    }
}
