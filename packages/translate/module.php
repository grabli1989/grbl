<?php

use Translate\Providers\TranslateApiServiceProvider;

return [
    'providers' => [
        TranslateApiServiceProvider::class,
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
