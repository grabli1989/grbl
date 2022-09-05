<?php

namespace Realty\Services\Properties;

use Realty\Commands\Question\CreateQuestion;
use Realty\Questions\Director;
use Realty\Questions\QuestionBuilder;

class CreateQuestionService
{
    public function __construct(
        private readonly Director $director,
        private readonly QuestionBuilder $builder
    ) {
        $this->director->setBuilder($this->builder);
    }

    /**
     * @param  CreateQuestion  $command
     * @return void
     */
    public function handle(CreateQuestion $command): void
    {
        $this->director->buildQuestion($command);
    }
}
