<?php

namespace Realty\Questions;

use Realty\Commands\Question\CreateQuestion;
use Realty\Commands\Question\UpdateQuestion;
use Realty\Models\Question;

class Director
{
    private QuestionBuilder $builder;

    /**
     * @param  QuestionBuilder  $builder
     * @return void
     */
    public function setBuilder(QuestionBuilder $builder): void
    {
        $this->builder = $builder;
    }

    /**
     * @param  CreateQuestion  $dto
     * @return void
     */
    public function buildQuestion(CreateQuestion $dto): void
    {
        $this->produceMain($dto);
        $this->builder->getQuestion()->save();
    }

    public function updateQuestion(UpdateQuestion $dto): void
    {
        $this->builder->setQuestion(Question::find($dto->id));
        $this->produceMain($dto);
        $this->builder->getQuestion()->save();
    }

    /**
     * @param  CreateQuestion|UpdateQuestion  $dto
     * @return void
     */
    private function produceMain(CreateQuestion|UpdateQuestion $dto): void
    {
        $this->builder->producePropertySet($dto->propertySet);
        $this->builder->produceRelateProperty($dto->relateProperty);
        $this->builder->produceSlug($dto->slug);
        $this->builder->produceType($dto->type);
        $this->builder->produceShowName($dto->showName);
        $this->builder->getQuestion()->save();
        foreach ($dto->name as $lang => $name) {
            $this->builder->produceName($lang, $name);
        }
    }
}
