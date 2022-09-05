<?php

use Settings\Providers\SettingsServiceProvider;

return [
    'providers' => [
        SettingsServiceProvider::class,
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
