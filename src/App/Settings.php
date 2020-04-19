<?php

declare(strict_types=1);

return [
    'settings' => [
        'storage' => realpath(__DIR__ . '/../../storage') . DIRECTORY_SEPARATOR,
        'db' => [
            'hostname' => getenv('DB_HOST'),
            'database' => getenv('DB_NAME'),
            'username' => getenv('DB_USER'),
            'password' => getenv('DB_PASS'),
        ],
    ],
];
