<?php
    require __DIR__ . '../../config/config.php'; 
    session_start();

    $userId = $_SESSION['userId'] ?? '';
    $input = json_decode(file_get_contents("php://input"), true);

    if (!$userId) {
        echo json_encode(["error" => "Not logged in"]);
        exit;
    }

    $updates = [];
    if (isset($input['name'])) $updates['name'] = $input['name'];
    if (isset($input['email'])) $updates['email'] = $input['email'];
    if (isset($input['password'])) $updates['password'] = password_hash($input['password'], PASSWORD_DEFAULT);

    if (empty($updates)) {
        echo json_encode(["error" => "No data to update"]);
        exit;
    }

    $database->getReference("users/$userId")->update($updates);

    echo json_encode(["success" => true, "message" => "User updated"]);
