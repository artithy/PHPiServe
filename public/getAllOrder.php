<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\classes\Order;
use App\traits\AuthUtils;

$order = new Order();
$orders = $order->getAll();

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    $order->printResponse([
        'status' => false,
        'message' => 'Only GET allowed'
    ]);
    exit;
}

$order->printResponse([
    'status' => true,
    'orders' => $orders
]);
