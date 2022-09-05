<?php

namespace Realty\Exceptions;

class CategoryException extends \Exception
{
    public const CODES = [
        0 => 'CATEGORY_NOT_FOUND',
    ];

    public static function categoryNotFound()
    {
        return new self('Category not found', 0);
    }
}
