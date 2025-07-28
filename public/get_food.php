<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\classes\Food;

header('Content-Type: application/json');

$food = new Food();
$data = $food->getAll();

echo json_encode(['status' => true, 'data' => $data]);
