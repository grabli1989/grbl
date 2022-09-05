<?php

namespace Realty\Services\Properties;

use Realty\Commands\Question\CreateProperty;
use Realty\Models\Property;
use Realty\Models\PropertyTranslation;
use Realty\Models\Question;

class CreatePropertyService
{
    /**
     * @param  CreateProperty  $command
     * @return void
     */
    public function handle(CreateProperty $command): void
    {
        /** @var Question $question */
        $question = Question::find($command->question);

        /** @var Property $property */
        $property = $question->properties()->create([
            'position' => $command->position,
            'slug' => $command->slug,
        ]);

        foreach ($command->name as $lang => $name) {
            /** @var PropertyTranslation $translation */
            $translation = $property->translateOrNew($lang);
            $translation->name = $name;
            $translation->value = $command->value[$lang] ?? null;
        }

        $property->save();
    }
}
