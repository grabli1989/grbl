<?php

namespace Realty\Services\Properties;

use Realty\Commands\Question\DropSet;
use Realty\Models\PropertySet;

class DropSetService
{
    /**
     * @param  DropSet  $command
     * @return void
     */
    public function handle(DropSet $command): void
    {
        PropertySet::find($command->id)->delete();
    }
}
