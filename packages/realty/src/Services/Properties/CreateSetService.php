<?php

namespace Realty\Services\Properties;

use Realty\Commands\Question\CreateSet;
use Realty\Models\PropertySet;
use Realty\Models\PropertySetTranslation;

class CreateSetService
{
    /**
     * @param  CreateSet  $command
     * @return void
     */
    public function handle(CreateSet $command): void
    {
        $set = new PropertySet();
        foreach ($command->name as $lang => $name) {
            /** @var PropertySetTranslation $translation */
            $translation = $set->translateOrNew($lang);
            $translation->name = $name;
        }
        $set->save();
    }
}
