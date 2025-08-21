<?php
require_once __DIR__ . '/cors.php';
require_once __DIR__ . '/../vendor/autoload.php';

use App\classes\Cart;
use App\classes\CartItem;
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


if (!isset($_GET['cart_token']) || empty($_GET['cart_token'])) {
    http_response_code(400);
    $auth->printResponse([
        'status' => false,
        'message' => 'Cart Token is required',
    ]);
    exit;
}


$cart = new Cart();
$cart = $cart->getCartByToken($_GET['cart_token']);

if (!$cart) {
    http_response_code(404);
    $auth->printResponse([
        'status' => false,
        'message' => 'Cart not found',
    ]);
    exit;
}

$cartItem = new CartItem();
$deleted = $cartItem->delete($cart['id'], $input['food_id']);


if ($deleted) {
    http_response_code(200);
    $auth->printResponse([
        'status' => true,
        'message' => 'Cart item deleted successfully',
    ]);
} else {
    http_response_code(404);
    $auth->printResponse([
        'status' => false,
        'message' => 'Cart item not found or already deleted',
    ]);
}
