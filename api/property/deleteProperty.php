<?php
    require __DIR__ . '../../config/config.php'; 
    session_start();

    $userId = $_SESSION['userId'] ?? '';
    $input = json_decode(file_get_contents("php://input"), true);
    $propertyId = $input['propertyId'] ?? '';

    if (!$userId || !$propertyId) {
        echo json_encode(["error" => "User or property ID missing"]);
        exit;
    }

    // Get property
    $property = $database->getReference("properties/$propertyId")->getValue();

    if (!$property || $property['ownerId'] !== $userId) {
        echo json_encode(["error" => "Property not found or you do not own it"]);
        exit;
    }

    // Delete property
    $database->getReference("properties/$propertyId")->remove();

    echo json_encode(["success" => true, "message" => "Property deleted"]);
