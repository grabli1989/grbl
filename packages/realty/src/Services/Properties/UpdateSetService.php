<?php

namespace Realty\Services\Properties;

use Realty\Commands\Question\UpdateSet;
use Realty\Models\PropertySet;
use Realty\Models\PropertySetTranslation;

class UpdateSetService
{
    /**
     * @param  UpdateSet  $command
     * @return void
     */
    public function handle(UpdateSet $command): void
    {
        $set = PropertySet::find($command->id);
        foreach ($command->name as $lang => $name) {
            /** @var PropertySetTranslation $translation */
            $translation = $set->translateOrNew($lang);
            $translation->name = $name;
        }
        $set->save();
    }
}
