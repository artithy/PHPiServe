<?php


require_once __DIR__ . '/../vendor/autoload.php';

use App\classes\Cuisine;

header('Content-Type: application/json');

$cuisine = new Cuisine();
$data = $cuisine->getAll();

echo json_encode(['status' => true, 'data' => $data]);
