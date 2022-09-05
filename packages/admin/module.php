<?php

return [
    'providers' => [
    ],
    'routes' => [
        'api' => [
            __DIR__.'/routes/api.php',
            //
        ],
        'web' => [
            //
        ],
        'console' => [
            //
        ],
    ],
    'listen' => [
        //
    ],
    'commands' => [
        //        __DIR__ . '/src/Console/Commands'
    ],
    'guard' => 'sanctum',
];
