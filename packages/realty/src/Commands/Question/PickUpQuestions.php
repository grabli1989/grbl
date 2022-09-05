<?php

namespace Realty\Commands\Question;

class PickUpQuestions
{
    /**
     * @param  array  $properties
     */
    public function __construct(public readonly array $properties)
    {
    }
}
