<?php

namespace Realty\Services\Properties;

use Realty\Commands\Question\UpdateProperty;
use Realty\Models\Property;
use Realty\Models\PropertyTranslation;
use Realty\Models\Question;

class UpdatePropertyService
{
    /**
     * @param  UpdateProperty  $command
     * @return void
     */
    public function handle(UpdateProperty $command): void
    {
        /** @var Property $property */
        $property = Property::find($command->id);

        $property->update([
            'position' => $command->position,
            'slug' => $command->slug,
        ]);

        $property->setQuestion(Question::find($command->question));

        foreach ($command->name as $lang => $name) {
            /** @var PropertyTranslation $translation */
            $translation = $property->translateOrNew($lang);
            $translation->name = $name;
            $translation->value = $command->value[$lang] ?? null;
        }

        $property->save();
    }
}
