<?php
    require __DIR__ . '../../config/config.php'; 

    // Get all properties
    $allProperties = $database->getReference('properties')->getValue();

    if (!$allProperties) {
        echo json_encode([]);
        exit;
    }

    // Convert associative array to indexed array for shuffling
    $propertiesArray = [];
    foreach ($allProperties as $id => $prop) {
        $prop['id'] = $id; // keep the ID
        $propertiesArray[] = $prop;
    }

    // Shuffle the array to randomize
    shuffle($propertiesArray);

    // Take only 30 properties
    $randomProperties = array_slice($propertiesArray, 0, 30);

    // Return as JSON
    echo json_encode($randomProperties);
