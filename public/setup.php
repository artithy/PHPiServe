<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\classes\Food;
use App\classes\Order;
use App\classes\OrderItem;
use App\classes\Token;
use App\classes\Auth;
use App\classes\Cart;
use App\classes\Cuisine;

// Connect database
$food = new Food();
$order = new Order();
$orderItem = new OrderItem();
$token = new Token();
$auth = new Auth();
$cart = new Cart();
$cuisine = new Cuisine(); // যদি cart class থাকে

// Create tables
$cart->create_table();
$food->createTable();
$order->createTable();
$orderItem->createTable();
$token->createTable();
$auth->create_table();
$cuisine->createTable();


echo "All tables created successfully!";
