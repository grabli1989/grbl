<?php

namespace Realty\Commands\Question;

class UpdateSet
{
    /**
     * @param  int  $id
     * @param  array  $name
     */
    public function __construct(
        public readonly int $id,
        public readonly array $name,
    ) {
    }
}
