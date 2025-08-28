<?php

namespace App\classes;

use App\Database;
use App\traits\AuthUtils;
use PDO;

class Order extends Database
{
    public $pdo;
    use AuthUtils;

    public function __construct()
    {
        // try {
        //     $this->pdo = $this->connect();
        //     if ($this->pdo) {
        //         echo "DB Connected successfully";
        //     }
        // } catch (\PDOException $e) {
        //     echo "DB Connection failed: " . $e->getMessage();
        // }

        $this->pdo = $this->connect();
    }

    public function createTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS orders(
        id INT AUTO_INCREMENT PRIMARY KEY,
        cart_id INT NOT NULL,
        customer_name VARCHAR(255) NOT NULL,
        customer_address TEXT NOT NULL,
        customer_phone VARCHAR(20) NOT NULL,
        order_notes TEXT,
        total_price DECIMAL(10,2) NOT NULL,
        payment_status VARCHAR(50) DEFAULT 'pending',
        status VARCHAR(50) DEFAULT 'pending',  
        order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        order_id VARCHAR(50) UNIQUE NOT NULL,
        invoice_id VARCHAR(50) DEFAULT NULL,
        FOREIGN KEY(cart_id) REFERENCES carts(id) ON DELETE CASCADE
        )";

        return $this->pdo->exec($sql);
    }

    public function createOrder($cart_id, $customer_name, $customer_address, $customer_phone, $order_notes, $total_price, $order_id, $invoice_id = null)
    {
        $invoice_id_quoted = $invoice_id === null ? 'NULL' : $this->pdo->quote($invoice_id);

        $sql = "INSERT INTO orders (
    cart_id, customer_name, customer_address, customer_phone, order_notes, total_price, order_id, invoice_id, status
) VALUES (
    {$this->pdo->quote($cart_id)},
    {$this->pdo->quote($customer_name)},
    {$this->pdo->quote($customer_address)},
    {$this->pdo->quote($customer_phone)},
    {$this->pdo->quote($order_notes)},
    {$this->pdo->quote($total_price)},
    {$this->pdo->quote($order_id)},
    $invoice_id_quoted,
    'pending'
)";
        $this->pdo->exec($sql);
        return $this->pdo->lastInsertId();




        $this->pdo->exec($sql);
        return $this->pdo->lastInsertId();
    }


    public function getAll()
    {
        $sql = "SELECT* FROM orders ORDER BY order_date DESC";

        return $this->pdo->query($sql)
            ->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getById($id)
    {
        $sql = "SELECT* FROM orders WHERE id = $id";

        return $this->pdo->query($sql)
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($data, $id)
    {
        $sql = "UPDATE orders SET 
        cart_id = '{$data['cart_id']}',
        customer_name = '{$data['customer_name']}',
        customer_address = '{$data['customer_address']}',
        customer_phone = '{$data['customer_phone']}',  
        order_notes = '{$data['order_notes']}',
        total_price = '{$data['total_price']}',
        payment_status = '{$data['payment_status']}',
        status = '{$data['status']}',
        order_id = '{$data['order_id']}',   
        invoice_id = '{$data['invoice_id']}'
        WHERE id = $id";

        return $this->pdo->exec($sql);
    }
    public function updateStatus($id, $status)
    {
        $valid_statuses = ['pending', 'ordered', 'shipped', 'delivered', 'cancelled', 'returned'];

        if (!in_array($status, $valid_statuses)) {
            throw new \Exception("Invalid status: $status");
        }

        $sql = "UPDATE orders SET status = '{$status}' WHERE id = $id";
        return $this->pdo->exec($sql);
    }



    // public function delete($id)
    // {
    //     $sql = "DELETE FROM orders WHERE id = $id";
    //     return $this->pdo->exec($sql);
    // }
}
