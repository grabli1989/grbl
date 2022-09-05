<?php

namespace Realty\Interfaces;

use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;

interface MediaServiceInterface
{
    public const CONVERSION_NAMES = [
        'PREVIEW' => 'preview',
        'FULL' => 'full',
        'SHORT' => 'short',
        'LONG' => 'long',
    ];

    public function prepareMedias(MediaCollection $collection): array;
}
