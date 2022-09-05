<?php

namespace Realty\Commands\Question;

class UpdateQuestion
{
    /**
     * @param  int  $id
     * @param  int  $propertySet
     * @param  int|null  $relateProperty
     * @param  string  $type
     * @param  string  $slug
     * @param  bool  $showName
     * @param  array  $name
     */
    public function __construct(
        public readonly int $id,
        public readonly int $propertySet,
        public readonly ?int $relateProperty,
        public readonly string $type,
        public readonly string $slug,
        public readonly bool $showName,
        public readonly array $name,
    ) {
    }
}
