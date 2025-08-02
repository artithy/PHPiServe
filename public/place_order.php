<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\classes\Cart;
use App\classes\CartItem;
use App\classes\Order;
use App\classes\OrderItem;
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

$input = json_decode(file_get_contents('php://input'), true);

if (
    !isset($input['cart_token'], $input['customer_name'], $input['delivery_address'], $input['phone_number'], $input['items']) ||
    empty($input['items'])
) {
    http_response_code(400);
    $auth->printResponse([
        'status' => false,
        'message' => 'Required fields are missing or items are empty'
    ]);
    exit;
}

// Get cart data by token
$cart = new Cart();
$cartData = $cart->getCartByToken($input['cart_token']);

if (!$cartData) {
    http_response_code(404);
    $auth->printResponse([
        'status' => false,
        'message' => 'Cart not found'
    ]);
    exit;
}

$order = new Order();
$orderItem = new OrderItem();

// Create table if not exists
$order->createTable();
$orderItem->createTable();

// Create order
$order_id = $order->createOrder(
    $cartData['id'],
    $input['customer_name'],
    $input['delivery_address'],
    $input['phone_number'],
    $input['order_notes'] ?? '',
    $input['total_price'] ?? 0.00,
    uniqid('ORD_')
);

// Add order items
$orderItem->addItems($order_id, $input['items']);

// ✅ Update order status
$order->updateStatus($order_id, 'ordered');

// Success response
http_response_code(201);
$auth->printResponse([
    'status' => true,
    'message' => 'Order placed successfully',
    'order_id' => $order_id
]);
