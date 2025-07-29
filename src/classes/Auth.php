<?php

namespace App\classes;

use App\Abstract\Authbase;
use App\classes\Token;
use PDO;

class Auth extends Authbase
{
    public $pdo;

    public function __construct()
    {
        $this->pdo = $this->connect();
    }

    public function create_table()
    {
        $sql = "CREATE TABLE IF NOT EXISTS user (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";

        return $this->pdo->exec($sql);
    }
    public function signup($user_name, $email, $password)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM user WHERE email = '$email'");
        $stmt->execute();

        if ($stmt->rowCount()) {
            return [
                'status' => false,
                'message' => 'User already exist'
            ];
        }

        $hashedPassword = $this->hashPassword($password);


        $stmt = $this->pdo->prepare("INSERT INTO user(user_name, email, password) VALUES ('$user_name', '$email', '$hashedPassword')");
        $stmt->execute();

        $user_id = $this->pdo->lastInsertId();

        $tokenValue = bin2hex(random_bytes(32));

        $token = new Token();
        $token->createTable();
        $token->createTable([
            'token' => $tokenValue,
            'user_id' => $user_id
        ]);

        return [
            'status' => true,
            'message' => 'Signup successful',
            'user_id' => $user_id,
            'token' => $tokenValue
        ];
    }
}
