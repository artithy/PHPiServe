<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\classes\Order;
use App\traits\AuthUtils;

$order = new Order();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    $order->printResponse([
        'status' => false,
        'message' => 'Only POST method allowed'
    ]);
    exit;
}

if (!isset($_GET['order_id']) || empty($_GET['order_id'])) {
    http_response_code(400);
    $order->printResponse([
        'status' => false,
        'message' => 'Order ID is required'
    ]);
    exit;
}

$order = new Order();
$order->updateStatus($_GET['order_id'], 'ordered');
$order_id = $order->getById($_GET['order_id']);

if (!$order_id) {
    http_response_code(404);
    $order->printResponse([
        'status' => false,
        'message' => 'Order not found'
    ]);
    exit;
}

$order->printResponse([
    'status' => true,
    'order' => $order_id
]);
