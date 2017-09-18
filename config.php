<?php

return [
    'scheme' => 'http',
    'token' => [
        'key' => 'dfaawde521',
        'method' => 'AES-256-CBC',
        'iv' => '12323asd',
    ],
    'image' => [
        'count' => 10,
        'extensions' => [
            'jpg',
            'png',
            'gif'
        ],
        'min' => [
            'size' => 1000,
            'width' => 600,
            'height' => 400,
        ],
        'max' => [
            'size' => 2000000,
            'width' => 2048,
            'height' => 1536,
        ],
        'sizes' => [
            '200x200',
            '1024x768',
        ],
    ],
];