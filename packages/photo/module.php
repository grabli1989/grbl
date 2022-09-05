<?php

use Photo\Providers\MediaServiceProvider;

return [
    'providers' => [
        MediaServiceProvider::class,
        //
    ],
    'routes' => [
        'api' => [
            __DIR__.'/routes/api.php',
        ],
        'web' => [
            //
        ],
        'console' => [
            //
        ],
        //
    ],
];
