<?php

namespace Realty\Commands\Question;

class CreateSet
{
    /**
     * @param  array  $name
     */
    public function __construct(
        public readonly array $name,
    ) {
    }
}
