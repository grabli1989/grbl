<?php

use Markable\Providers\FavoriteManagerServiceProvider;
use Markable\Providers\PhoneViewsManagerServiceProvider;
use Markable\Providers\ViewsManagerServiceProvider;

return [
    'providers' => [
        ViewsManagerServiceProvider::class,
        FavoriteManagerServiceProvider::class,
        PhoneViewsManagerServiceProvider::class,

    ],
    'routes' => [
        'api' => [
            //
        ],
        'web' => [
            //
        ],
        'console' => [
            //
        ],
    ],
    'commands' => [
        //
    ],
];
