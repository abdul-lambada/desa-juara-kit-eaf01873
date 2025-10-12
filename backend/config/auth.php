<?php

return [
    'guard' => [
        'except' => [
            '/auth/login',
            '/auth/logout',
            '/auth/process',
        ],
    ],
    'supabase' => [
        'url' => rtrim(env('SUPABASE_URL', ''), '/'),
        'service_role_key' => env('SUPABASE_SERVICE_ROLE_KEY', ''),
        'anon_key' => env('SUPABASE_ANON_KEY', ''),
    ],
];
