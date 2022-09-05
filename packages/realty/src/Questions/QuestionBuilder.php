<?php

namespace Realty\Questions;

use Realty\Models\Question;
use Realty\Models\QuestionTranslation;

class QuestionBuilder
{
    protected Question $question;

    public function __construct()
    {
        $this->reset();
    }

    /**
     * @return void
     */
    public function reset(): void
    {
        $this->question = new Question();
    }

    /**
     * @param  int  $propertySetId
     * @return void
     */
    public function producePropertySet(int $propertySetId): void
    {
        $this->question->property_set_id = $propertySetId;
    }

    /**
     * @param  int|null  $relatePropertyId
     * @return void
     */
    public function produceRelateProperty(?int $relatePropertyId): void
    {
        $this->question->relate_property_id = $relatePropertyId;
    }

    /**
     * @param  string  $type
     * @return void
     */
    public function produceType(string $type): void
    {
        $this->question->type = $type;
    }

    /**
     * @param  string  $slug
     * @return void
     */
    public function produceSlug(string $slug): void
    {
        $this->question->slug = $slug;
    }

    /**
     * @param  bool  $showName
     * @return void
     */
    public function produceShowName(bool $showName): void
    {
        $this->question->show_name = $showName;
    }

    /**
     * @param  string  $lang
     * @param  string  $name
     * @return void
     */
    public function produceName(string $lang, string $name): void
    {
        /** @var QuestionTranslation $translation */
        $translation = $this->question->translateOrNew($lang);
        $translation->name = $name;
    }

    /**
     * @return Question
     */
    public function getQuestion(): Question
    {
        return $this->question;
    }

    /**
     * @param  Question  $question
     * @return void
     */
    public function setQuestion(Question $question): void
    {
        $this->question = $question;
    }
}
