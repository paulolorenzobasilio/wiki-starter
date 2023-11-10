<?php

const APP_ROOT = __DIR__;

return [
    'settings' => [
        'slim' => [
            'displayErrorDetails' => true,
            'logErrors' => true,
            'logErrorDetails' => true
        ],
        'doctrine' => [
            'dev_mode' => true,
            'cache_dir' => APP_ROOT . '/var/doctrine',
            'metadata_dirs' => [APP_ROOT . '/src/Entity'],
            'connection' => [
                'driver' => 'pdo_sqlite',
                'path' => 'database.sqlite'
            ]
        ]
    ]
];
