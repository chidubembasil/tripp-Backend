<?php
    require __DIR__ . '../../config/config.php'; // load $database

    session_start(); // Start the PHP session

    // Get incoming JSON data
    $input = json_decode(file_get_contents("php://input"), true);

    if (!$input || !isset($input['email']) || !isset($input['password']) || !isset($input['name'])) {
        echo json_encode(["error" => "Invalid input"]);
        exit;
    }

    $email = $input['email'];
    $password = $input['password'];
    $name = $input['name'];

    // Validate
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["error" => "Invalid email format"]);
        exit;
    }

    if (strlen($password) < 6) {
        echo json_encode(["error" => "Password must be at least 6 characters"]);
        exit;
    }

    // Save user in Firebase and get the generated ID
    $newUserRef = $database->getReference('users')->push([
        'name' => $name,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'createdAt' => time()
    ]);

    $userId = $newUserRef->getKey(); // Firebase generated ID

    // Store user info in session
    $_SESSION['userId'] = $userId;
    $_SESSION['userName'] = $name;
    $_SESSION['userEmail'] = $email;

    echo json_encode([
        "success" => true,
        "message" => "User registered",
        "userId" => $userId
    ]);
