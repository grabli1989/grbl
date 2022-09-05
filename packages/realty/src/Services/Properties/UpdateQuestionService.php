<?php

namespace Realty\Services\Properties;

use Realty\Commands\Question\UpdateQuestion;
use Realty\Questions\Director;
use Realty\Questions\QuestionBuilder;

class UpdateQuestionService
{
    public function __construct(
        private readonly Director $director,
        private readonly QuestionBuilder $builder
    ) {
        $this->director->setBuilder($this->builder);
    }

    /**
     * @param  UpdateQuestion  $command
     * @return void
     */
    public function handle(UpdateQuestion $command): void
    {
        $this->director->updateQuestion($command);
    }
}
