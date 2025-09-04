<?php
    require __DIR__ . '../../config/config.php'; 
    require __DIR__ . '../../config/cloudinary.php';
    session_start();

    $input = $_POST;
    $title = $input['title'] ?? '';
    $price = $input['price'] ?? '';
    $location = $input['location'] ?? '';
    $ownerId = $_SESSION['userId'] ?? '';

    if (!$title || !$price || !$location || !$ownerId) {
        echo json_encode(["error" => "All fields are required"]);
        exit;
    }

    // Handle image upload
    $imageUrl = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $tmpFilePath = $_FILES['image']['tmp_name'];
        $filename = $_FILES['image']['name'];

        // Upload to Cloudinary
        $uploadResult = $cloudinary->uploadApi()->upload($tmpFilePath, [
            'folder' => 'properties', // optional folder
            'public_id' => pathinfo($filename, PATHINFO_FILENAME)
        ]);

        $imageUrl = $uploadResult['secure_url']; // get the Cloudinary URL
    }

    // Save property in Firebase
    $newProperty = $database->getReference('properties')->push([
        'title' => $title,
        'price' => $price,
        'location' => $location,
        'ownerId' => $ownerId,
        'image' => $imageUrl,
        'createdAt' => time()
    ]);

    echo json_encode([
        "success" => true,
        "message" => "Property added",
        "propertyId" => $newProperty->getKey(),
        "imageUrl" => $imageUrl
    ]);
