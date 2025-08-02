<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\classes\Order;
use App\traits\AuthUtils;

$auth = new class {
    use AuthUtils;
};

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    $auth->printResponse([
        'status' => false,
        'message' => 'Only POST method allowed'
    ]);
    exit;
}

if (!isset($_GET['order_id']) || empty($_GET['order_id'])) {
    http_response_code(400);
    $auth->printResponse([
        'status' => false,
        'message' => 'Order ID is required'
    ]);
    exit;
}

$order = new Order();
$order_id = $order->getById($_GET['order_id']);

if (!$order_id) {
    http_response_code(404);
    $auth->printResponse([
        'status' => false,
        'message' => 'Order not found'
    ]);
    exit;
}

$auth->printResponse([
    'status' => true,
    'order' => $order_id
]);
