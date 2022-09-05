<?php

namespace Translate\Exceptions;

class TranslateException extends \Exception
{
    public const CODES = [
        0 => 'LANGUAGE_NOT_AVAILABLE',
    ];

    /**
     * @return TranslateException
     */
    public static function languageNotAvailable(): TranslateException
    {
        return new self('Language not available', 0);
    }
}
