<?php

namespace App\classes;

use App\Database;
use PDO;

class Token extends Database
{
    public function createTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS token (
        id INT AUTO_INCREMENT PRIMARY KEY,
        token VARCHAR(255) NOT NULL,
        user_id INT NOT NULL,
        is_active TINYINT(1) DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

        return $this->connect()->exec($sql);
    }

    public function create($data)
    {
        $sql = "INSERT INTO token (token , user_id, is_active)
            VALUES (
            '{$data['token']}',
            '{$data['user_id']}',
            1)";

        return $this->pdo->exec($sql);
    }

    public function validate($token)
    {
        $sql = "SELECT * FROM token WHERE token = '$token' AND is_active = 1";
        $stmt = $this->connect()->query($sql);
        return $stmt->fetch();
    }

    public function deactivate($token)
    {
        $sql = "UPDATE token SET is_active = 0 WHERE token ='$token'";
        $this->connect()->query($sql);
    }

    public function getUserIdByToken($token)
    {
        $sql = "SELECT user_id FROM token WHERE token = '$token' AND is_active = 1 LIMIT 1";
        $stmt = $this->connect()->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['user_id'] ?? false;
    }
}
