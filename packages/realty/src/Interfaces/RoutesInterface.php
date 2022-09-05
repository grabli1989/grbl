<?php

namespace Realty\Interfaces;

interface RoutesInterface
{
    public const ADS_PREFIX = 'ob';

    public const REACTIONS_PREFIX = [
        'FAVORITES' => 'favorites',
        'PHONE_VIEWS' => 'phone-views',
    ];
}
