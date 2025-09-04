<?php
    require __DIR__.'/vendor/autoload.php';
    use Kreait\Firebase\Factory;

    $factory = (new Factory)
    ->withServiceAccount('tripp-b0eb9-firebase-adminsdk-fbsvc-e093880ac3.json')
    ->withDatabaseUri('https://tripp-b0eb9-default-rtdb.firebaseio.com/');


    $database = $factory->createDatabase();