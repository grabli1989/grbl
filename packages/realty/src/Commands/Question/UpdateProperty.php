<?php

namespace Realty\Commands\Question;

class UpdateProperty
{
    /**
     * @param  int  $id
     * @param  int  $question
     * @param  int  $position
     * @param  string  $slug
     * @param  array  $name
     * @param  array  $value
     */
    public function __construct(
        public readonly int $id,
        public readonly int $question,
        public readonly int $position,
        public readonly string $slug,
        public readonly array $name,
        public readonly array $value,
    ) {
    }
}
