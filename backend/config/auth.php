<?php

return [
    'guard' => [
        'except' => [
            '/auth/login',
            '/auth/logout',
            '/auth/process',
        ],
    ],
    'credentials' => [
        'email' => env('ADMIN_EMAIL', 'admin@desajuara.id'),
        'password' => env('ADMIN_PASSWORD', 'password'),
        'password_hash' => env('ADMIN_PASSWORD_HASH', ''),
        'name' => env('ADMIN_NAME', 'Admin Desa Juara'),
    ],
];
