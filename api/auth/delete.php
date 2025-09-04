<?php
    require __DIR__ . '../../config/config.php';
    session_start();

    $userId = $_SESSION['userId'] ?? '';
    if (!$userId) {
        echo json_encode(["error" => "Not logged in"]);
        exit;
    }

    // Delete all properties of this user
    $properties = $database->getReference('properties')->getValue();
    if ($properties) {
        foreach ($properties as $propId => $prop) {
            if ($prop['ownerId'] === $userId) {
                $database->getReference("properties/$propId")->remove();
            }
        }
    }

    // Delete user
    $database->getReference("users/$userId")->remove();

    // Destroy session
    session_destroy();

    echo json_encode(["success" => true, "message" => "User and all their properties deleted"]);
