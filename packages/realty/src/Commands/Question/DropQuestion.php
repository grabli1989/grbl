<?php

namespace Realty\Commands\Question;

class DropQuestion
{
    /**
     * @param  int  $id
     */
    public function __construct(
        public readonly int $id,
    ) {
    }
}
