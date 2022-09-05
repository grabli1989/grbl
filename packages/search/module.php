<?php

use Search\Providers\SearchServiceProvider;

return [
    'providers' => [
        SearchServiceProvider::class,
    ],
    'routes' => [
        'api' => [
            __DIR__.'/routes/search.api.php',
        ],
        'web' => [
            //
        ],
        'console' => [
            //
        ],
        //
    ],
    'listen' => [
        //
    ],
    'paginate' => [
        'perPage' => 25,
    ],
];
