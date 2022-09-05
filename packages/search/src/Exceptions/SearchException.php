<?php

namespace Search\Exceptions;

use JetBrains\PhpStorm\Pure;

class SearchException extends \Exception
{
    public const CODES = [
        0 => 'INVALID_SEARCHABLE',
        //
    ];

    /**
     * @param  string  $searchable
     * @return SearchException
     */
    #[Pure]
 public static function searchableException(string $searchable): SearchException
 {
     return new self('Invalid searchable', 0);
 }
}
