<?php

use Phone\Providers\ConfirmationCodeGeneratorServiceProvider;
use Phone\Providers\PhoneServiceProvider;
use Phone\Providers\SmsServiceProvider;

return [
    'providers' => [
        ConfirmationCodeGeneratorServiceProvider::class,
        SmsServiceProvider::class,
        PhoneServiceProvider::class,

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
    'commands' => [
        __DIR__.'/src/Console/Commands',
    ],
];
