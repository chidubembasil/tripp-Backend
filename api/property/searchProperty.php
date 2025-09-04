<?php
    require __DIR__ . '../../config/config.php'; 

    $input = json_decode(file_get_contents("php://input"), true);

    $searchTerm = strtolower($input['searchTerm'] ?? ''); // text search
    $minPrice = $input['minPrice'] ?? null;
    $maxPrice = $input['maxPrice'] ?? null;
    $location = strtolower($input['location'] ?? null);

    // Get all properties
    $allProperties = $database->getReference('properties')->getValue();
    $results = [];

    if ($allProperties) {
        foreach ($allProperties as $id => $property) {
            // Text search
            $matchesSearch = $searchTerm === '' || strpos(strtolower($property['title']), $searchTerm) !== false;

            // Price filter
            $matchesPrice = true;
            if ($minPrice !== null && $property['price'] < $minPrice) $matchesPrice = false;
            if ($maxPrice !== null && $property['price'] > $maxPrice) $matchesPrice = false;

            // Location filter
            $matchesLocation = true;
            if ($location !== null && strtolower($property['location']) !== $location) $matchesLocation = false;

            if ($matchesSearch && $matchesPrice && $matchesLocation) {
                $results[$id] = $property;
            }
        }
    }

    echo json_encode($results);
