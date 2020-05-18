<?php
return [
    // Cache
    'cache' => [
        'default' => 'sae',
        'stores' => [
            'sae' => [
                'type' => 'CodeSinging\ThinkSae\Drivers\Cache'
            ]
        ]
    ],

    // Log
    'log' => [
        'default' => 'sae',
        'channels' => [
            'sae' => [
                'type' => 'CodeSinging\ThinkSae\Drivers\Log'
            ]
        ]
    ],

    // Template
    'view' => [
        'compile_type' => 'CodeSinging\ThinkSae\Drivers\Template'
    ],

    // Database
    'database' => [
        'default' => 'sae',
        'connections' => [
            'sae' => defined('SAE_APPNAME') ? [
                'type' => 'mysql',
                'hostname' => SAE_MYSQL_HOST_M . ',' . SAE_MYSQL_HOST_S,
                'database' => SAE_MYSQL_DB,
                'username' => SAE_MYSQL_USER,
                'password' => SAE_MYSQL_PASS,
                'hostport' => SAE_MYSQL_PORT . ',' . SAE_MYSQL_PORT,
                'charset' => 'utf8mb4',
                'deploy' => 1,
                'rw_separate' => true,
            ] : []
        ]
    ],
];