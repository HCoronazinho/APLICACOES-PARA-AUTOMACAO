<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Projeto Firebase padrão
    |--------------------------------------------------------------------------
    |
    | Caso você tenha múltiplos projetos Firebase, defina aqui qual será o
    | padrão a ser utilizado quando chamar app('firebase.*').
    |
    */

    'default' => env('FIREBASE_PROJECT', 'app'),

    /*
    |--------------------------------------------------------------------------
    | Projetos
    |--------------------------------------------------------------------------
    |
    | Configure abaixo os projetos Firebase utilizados. 
    | O campo `credentials` deve apontar para o arquivo JSON baixado do Firebase.
    |
    */

    'projects' => [
        'app' => [

            // 🔧 Corrigido: precisa ser array com chave 'file'
            'credentials' => [
                'file' => env('FIREBASE_CREDENTIALS'),
            ],

            'auth' => [
                'tenant_id' => env('FIREBASE_AUTH_TENANT_ID'),
            ],

            'firestore' => [
                // Configurações adicionais, se necessário
            ],

            'database' => [
                'url' => env('FIREBASE_DATABASE_URL'),
            ],

            'dynamic_links' => [
                'default_domain' => env('FIREBASE_DYNAMIC_LINKS_DEFAULT_DOMAIN'),
            ],

            'storage' => [
                'default_bucket' => env('FIREBASE_STORAGE_DEFAULT_BUCKET'),
            ],

            'cache_store' => env('FIREBASE_CACHE_STORE', 'file'),

            'logging' => [
                'http_log_channel' => env('FIREBASE_HTTP_LOG_CHANNEL'),
                'http_debug_log_channel' => env('FIREBASE_HTTP_DEBUG_LOG_CHANNEL'),
            ],

            'http_client_options' => [
                'proxy' => env('FIREBASE_HTTP_CLIENT_PROXY'),
                'timeout' => env('FIREBASE_HTTP_CLIENT_TIMEOUT'),
                'guzzle_middlewares' => [],
            ],
        ],
    ],
];
