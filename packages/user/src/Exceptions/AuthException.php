<?php

namespace User\Exceptions;

use JetBrains\PhpStorm\Pure;

class AuthException extends \Exception
{
    public const CODES = [
        0 => 'COMPARE_PASSWORDS_FAIL',
        1 => 'PASSWORDS_IDENTICAL',

    ];

    /**
     * @return AuthException
     */
    #[Pure]
 public static function PasswordsDoNotIdenticalException(): AuthException
 {
     return new self('The old password does not match the current one', 0);
 }

    /**
     * @return AuthException
     */
    public static function passwordsIdenticalException(): AuthException
    {
        return new self('Passwords identical', 1);
    }
}
