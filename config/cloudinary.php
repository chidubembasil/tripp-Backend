<?php
    require __DIR__.'/cloudinary/vendor/autoload.php';

    use Cloudinary\Cloudinary;

    $cloudinary = new Cloudinary([
        'cloud' => [
            'cloud_name' => 'dh9ezuvme',
            'api_key'    => '982761967286941',
            'api_secret' => 'KRPRfLbNYO6GWMyhuPy1lznHrmQ',
        ],
        'url' => [
            'secure' => true
        ]
    ]);
    