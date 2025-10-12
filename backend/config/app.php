<?php

return [
    'name' => 'Desa Juara Admin',
    'env' => env('APP_ENV', 'production'),
    'debug' => (bool) env('APP_DEBUG', false),
    'url' => env('APP_URL', 'http://localhost'),
    'desa_id' => (int) env('APP_DESA_ID', 1),
    'timezone' => 'Asia/Jakarta',
    'locale' => 'id',
];
