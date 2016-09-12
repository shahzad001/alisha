<?php

return [

    'iOS'     => [
        'environment' => env('IOS_PUSH_ENV', 'development'),
        'certificate' => env('IOS_PUSH_CERT', __DIR__ . '/ios-push-notification-certificates/development/certificate.pem'), 
        'passPhrase'  => env('IOS_PUSH_PASSWORD', 'password'),
        'service'     => 'apns'
    ],

    'android' => [
        'environment' => 'development',
        'apiKey'      => 'AIzaSyCOv9AjpeZu2RZdK33fkONjTbwfkoNeMoA',
        'service'     => 'gcm'
    ]

];