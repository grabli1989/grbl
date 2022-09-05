<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Realty\Models\PropertySet;
use Realty\Models\PropertySetTranslation;
use Realty\Models\Question;
use Realty\Models\QuestionTranslation;
use Realty\Models\Property;
use Realty\Models\PropertyTranslation;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $questionsSet = json_decode(Storage::disk('local')->get('resources/questions_set.json'));

        echo(PHP_EOL . 'Start questions creation' . PHP_EOL);

        foreach ($questionsSet as $set) {
            echo('Create set: ' . $set->slug . PHP_EOL);
            $newSet = new PropertySet();
            foreach ($set->name as $lang => $name) {
                /** @var PropertySetTranslation $translation */
                $translation = $newSet->translateOrNew($lang);
                $translation->name = $name;
            }
            $newSet->save();
            if (isset($set->questions)) {
                $this->questionsProcessing($newSet, $set->questions);
            }
        }

        echo(PHP_EOL . 'Finish questions creation' . PHP_EOL);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $allPropertySets = PropertySet::all();
        foreach ($allPropertySets as $set) {
            $set->delete();
        }
    }

    /**
     * Создание вопросов для сетов
     *
     * @param $set
     * @param $questions
     */
    private function questionsProcessing($set, $questions)
    {
        foreach ($questions as $question) {
            echo("-- create question: " . $question->slug . PHP_EOL);

            $newQuestion = $set->questions()->create([
                'slug' => $question->slug,
                'type' => $question->type,
                'show_name' => $question->showName,
            ]);

            foreach ($question->name as $lang => $name) {
                /** @var QuestionTranslation $translation */
                $translation = $newQuestion->translateOrNew($lang);
                $translation->name = $name;
            }
            $newQuestion->save();

            if ($newQuestion->slug === 'yearOfConstruction') {
                $this->yearOfConstructionProcessing($newQuestion);
            } else {
                $this->propertiesProcessing($newQuestion, $question->properties);
            }
        }
    }


    /**
     * Создание свойств для вопросов
     *
     * @param $question
     * @param $properties
     */
    private function propertiesProcessing($question, $properties)
    {
        foreach ($properties as $property) {

            $newProperty = $question->properties()->create([
                'position' => $property->position,
                'slug' => $property->slug,
            ]);

            foreach ($property->name as $lang => $name) {
                /** @var PropertyTranslation $translation */
                $translation = $newProperty->translateOrNew($lang);
                $translation->name = $name;
                $translation->value = $property->value->$lang ?? null;
            }
            $newProperty->save();

            echo("---- create property: " . $property->slug . PHP_EOL);
        }
    }


    /**
     * Обработка вопроса с годом постройки
     * (там нужно гинерировать много годов)
     *
     * @param $question
     */
    private function yearOfConstructionProcessing($question)
    {
        $position = 1;
        for ($year = 2022; $year >= 1900; $year--) {

            $newProperty = $question->properties()->create([
                'position' => $position,
                'slug' => (string)$position,
            ]);

            $name = ['ukraine', 'english', 'russian'];

            foreach ($name as $lang) {
                /** @var PropertyTranslation $translation */
                $translation = $newProperty->translateOrNew($lang);
                $translation->name = (string)$year;
                $translation->value = '';
            }
            $newProperty->save();

            echo("---- create property: " . $year . PHP_EOL);

            $position++;
        }
    }
};
