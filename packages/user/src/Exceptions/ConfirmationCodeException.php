<?php

namespace User\Exceptions;

class ConfirmationCodeException extends \Exception
{
    public const CODES = [
        0 => 'CODE_COMPARE_FAILED',
        1 => 'USER_ALREADY_CONFIRMED',
    ];

    /**
     * @return ConfirmationCodeException
     */
    public static function codeCompareException(): ConfirmationCodeException
    {
        return new self('You should be try with another code', 0);
    }

    /**
     * @return ConfirmationCodeException
     */
    public static function userAlreadyConfirmed(): ConfirmationCodeException
    {
        return new self('This action is no longer required for the current user', 1);
    }
}
