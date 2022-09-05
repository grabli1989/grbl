<?php

namespace Realty\Exceptions;

class AdException extends \Exception
{
    public const CODES = [
        0 => 'AD_ALREADY_APPROVED',
        1 => 'AD_ALREADY_DISABLED',
        2 => 'AD_ALREADY_REJECTED',
        3 => 'AD_NOT_FOUND',

    ];

    /**
     * @param  string  $message
     * @param  int  $code
     * @return static
     */
    public static function assertStatusException(string $message, int $code): self
    {
        return new self($message, $code);
    }
}
