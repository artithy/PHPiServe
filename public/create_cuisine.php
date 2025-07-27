<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\classes\Cuisine;

header('Content-Type: application/json');

$cuisine = new Cuisine();

$input = json_decode(file_get_contents('php://input'), true);
$name = $input['name'] ?? null;

if ($name) {
    $created = $cuisine->create($name);
    if ($created) {
        echo json_encode(['status' => true, 'message' => 'Cuisine created successfully']);
    } else {
        echo json_encode(['status' => false, 'message' => 'Cuisine creation failed']);
    }
} else {
    echo json_encode(['status' => false, 'message' => 'Name is required']);
}
