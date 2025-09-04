<?php
    require __DIR__ . '../../config/config.php'; 
    session_start();

    $userId = $_SESSION['userId'] ?? '';

    if (!$userId) {
        echo json_encode(["error" => "Not logged in"]);
        exit;
    }

    $user = $database->getReference("users/$userId")->getValue();

    echo json_encode($user);
