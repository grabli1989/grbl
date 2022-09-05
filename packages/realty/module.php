<?php

use Realty\Events\AdApprovedEvent;
use Realty\Events\AdDisabledEvent;
use Realty\Events\AdRejectedEvent;
use Realty\Events\Listeners\AdApprovedNotifyListener;
use Realty\Events\Listeners\AdRejectedNotifyListener;

return [
    'providers' => [
        //
    ],
    'routes' => [
        'api' => [
            __DIR__.'/routes/reactions.api.php',
            __DIR__.'/routes/ads.api.php',
            __DIR__.'/routes/categories.api.php',
            __DIR__.'/routes/properties.api.php',
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
    'listen' => [
        AdApprovedEvent::class => [
            AdApprovedNotifyListener::class,
        ],
        AdDisabledEvent::class => [

        ],
        AdRejectedEvent::class => [
            AdRejectedNotifyListener::class,
        ],
        //
    ],
];
