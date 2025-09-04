<?php
require __DIR__ . '../../config/config.php'; 
session_start(); // Start the PHP session

$input = json_decode(file_get_contents("php://input"), true);

$email = $input['email'] ?? '';
$password = $input['password'] ?? '';

// Get all users
$users = $database->getReference('users')->getValue();

if ($users) {
    foreach ($users as $id => $user) {
        if ($user['email'] === $email && password_verify($password, $user['password'])) {
            
            // Store user info in session
            $_SESSION['userId'] = $id;
            $_SESSION['userName'] = $user['name'];
            $_SESSION['userEmail'] = $user['email'];

            echo json_encode([
                "success" => true,
                "message" => "Login successful",
                "userId" => $id,
                "user" => $user
            ]);
            exit;
        }
    }
}

echo json_encode(["error" => "Invalid email or password"]);
