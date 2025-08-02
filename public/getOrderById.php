<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\classes\Order;
use App\traits\AuthUtils;


$auth = new class {
    use AuthUtils;
};
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    $auth->printResponse(['status' => false, 'message' => 'Only GET allowed']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    $auth->printResponse(['status' => false, 'message' => 'Only GET allowed']);
    exit;
}

$order = new Order();
$order_id = $order->getById($_GET['order_id']);

if ($order) {
    $auth->printResponse([
        'status' => true,
        'order' => $order_id
    ]);
} else {
    http_response_code(404);
    $auth->printResponse([
        'status' => false,
        'message' => 'Order not found'
    ]);
}
