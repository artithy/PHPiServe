<?php

namespace App;

use PDO;
use PDOException;

class Database
{
    private $host_name = "127.0.0.1";
    private $dbname = "foodmenuphp";
    private $username = "signup_login";
    private $password = "123456";

    public $pdo;

    public function connect()
    {
        try {
            $this->pdo = new PDO(
                "mysql:host={$this->host_name};port=3308;dbname={$this->dbname}",
                $this->username,
                $this->password
            );

            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->pdo;
        } catch (PDOException $e) {

            die("Connection failed: " . $e->getMessage());
        }
    }
}
