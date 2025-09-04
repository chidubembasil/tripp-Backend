<?php
require __DIR__ . '../../config/config.php'; 
session_start();

$userId = $_SESSION['userId'] ?? '';
if (!$userId) {
    echo json_encode(["error" => "Not logged in"]);
    exit;
}

// Get all properties
$allProperties = $database->getReference('properties')->getValue();
$userProperties = [];

if ($allProperties) {
    foreach ($allProperties as $propId => $property) {
        if ($property['ownerId'] === $userId) {
            $userProperties[$propId] = $property;
        }
    }
}

echo json_encode($userProperties);
