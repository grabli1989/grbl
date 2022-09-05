<?php

namespace Realty\Services\Properties;

use Realty\Commands\Question\DropProperty;
use Realty\Models\Property;

class DropPropertyService
{
    /**
     * @param  DropProperty  $command
     * @return void
     */
    public function handle(DropProperty $command): void
    {
        Property::find($command->id)->delete();
    }
}
