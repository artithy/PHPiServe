<?php
require_once __DIR__ . '/cors.php';
require_once __DIR__ . '/../vendor/autoload.php';

use App\classes\Order;
use App\traits\AuthUtils;

$order = new Order();
$order_id = $order->getById($_GET['order_id'] ?? null);

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    $order->printResponse([
        'status' => false,
        'message' => 'Only GET allowed'
    ]);
    exit;
}


if ($order_id) {
    $order->printResponse([
        'status' => true,
        'order' => $order_id
    ]);
} else {
    http_response_code(404);
    $order->printResponse([
        'status' => false,
        'message' => 'Order not found'
    ]);
}
