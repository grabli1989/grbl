<?php

namespace Realty\Interfaces;

interface TranslateApiInterface
{
    public const LANGUAGES = [
        'UKRAINE' => 'ukraine',
        'ENGLISH' => 'english',
        'RUSSIAN' => 'russian',
    ];

    /**
     * @param  string  $source
     * @param  string  $target
     * @param  string  $text
     * @return string
     */
    public function translate(string $source, string $target, string $text): string;
}
