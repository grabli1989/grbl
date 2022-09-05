<?php

namespace Realty\Commands\Question;

class DropProperty
{
    /**
     * @param  int  $id
     */
    public function __construct(
        public readonly int $id,
    ) {
    }
}
