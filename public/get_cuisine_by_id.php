<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\classes\Cuisine;

header('Content-Type: application/json');

$cuisine = new Cuisine;

$input = json_decode(file_get_contents('php://input'), true);
$id = $input['id'] ?? null;

if ($id) {
    $name = $cuisine->getCuisineNameById($id);
    if ($name) {
        echo json_encode(['status' => true, 'name' => $name]);
    } else {
        echo json_encode(['status' => false, 'name' => 'Cuisine not found']);
    }
} else {
    echo json_encode(['status' => false, 'name' => 'Id required']);
}
