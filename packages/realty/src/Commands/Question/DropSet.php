<?php

namespace Realty\Commands\Question;

class DropSet
{
    /**
     * @param  int  $id
     */
    public function __construct(
        public readonly int $id,
    ) {
    }
}
