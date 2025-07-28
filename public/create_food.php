<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\classes\Food;

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

$base64Image = $input['image'];
$imageInfo = explode(',', $base64Image);
$extension = str_replace(["data:image/", ";base64"], "", $imageInfo[0]);
$imageName = "images/" . uniqid() . "." . $extension;

file_put_contents(__DIR__ . '/' . $imageName, base64_decode($imageInfo[1]));
$input['image'] = $imageName;






$food = new Food();
$food->createTable();

if ($input) {
    $created = $food->create($input);
    if ($created) {
        echo json_encode(['status' => true, 'message' => 'Food created successfully']);
    } else {
        echo json_encode(['status' => false, 'message' => 'Food creation failed']);
    }
} else {
    echo json_encode(['status' => false, 'message' => 'Invalid input']);
}
