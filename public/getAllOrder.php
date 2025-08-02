<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\classes\Order;
use App\traits\AuthUtils;

$auth = new class {
    use AuthUtils;
};

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    $auth->printResponse([
        'status' => false,
        'message' => 'Only GET allowed'
    ]);
    exit;
}

$order = new Order();
$orders = $order->getAll();

$auth->printResponse([
    'status' => true,
    'orders' => $orders
]);
