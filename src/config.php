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
        'type' => 'mysql',
        'hostname' => SAE_MYSQL_HOST_M . ',' . SAE_MYSQL_HOST_S,
        'database' => SAE_MYSQL_DB,
        'username' => SAE_MYSQL_USER,
        'password' => SAE_MYSQL_PASS,
        'hostport' => SAE_MYSQL_PORT,
        'deploy' => 1,
        'rw_separate' => true,
    ]
];