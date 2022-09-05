<?php

use User\Events\ResetPasswordEvent;
use User\Events\UserConfirmedByPhoneEvent;
use User\Events\UserRegisteredEvent;
use User\Providers\AuthServiceProvider;
use User\Subscribers\NotifyUserAboutConfirmedByPhoneSubscriber;
use User\Subscribers\PhoneConfirmationCodeSubscriber;

return [
    'providers' => [
        AuthServiceProvider::class,
    ],
    'routes' => [
        'api' => [
            __DIR__.'/routes/api.php',
            __DIR__.'/routes/roles.php',
            __DIR__.'/routes/permissions.php',
            //
        ],
        'web' => [
            __DIR__.'/routes/web.php',
        ],
        'console' => [
            //
        ],
    ],
    'listen' => [
        UserConfirmedByPhoneEvent::class => [
            NotifyUserAboutConfirmedByPhoneSubscriber::class,
        ],
        UserRegisteredEvent::class => [
            PhoneConfirmationCodeSubscriber::class,
        ],
        ResetPasswordEvent::class => [
            PhoneConfirmationCodeSubscriber::class,
        ],
    ],
    'commands' => [
        __DIR__.'/src/Console/Commands',
    ],
    'admin' => [
        'password' => env('SUPER_ADMIN_PASSWORD', ''),
    ],
    'guard' => 'sanctum',
];
