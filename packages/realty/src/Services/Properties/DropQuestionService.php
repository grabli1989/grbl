<?php

namespace Realty\Services\Properties;

use Realty\Commands\Question\DropQuestion;
use Realty\Models\Question;

class DropQuestionService
{
    /**
     * @param  DropQuestion  $command
     * @return void
     */
    public function handle(DropQuestion $command): void
    {
        Question::find($command->id)->delete();
    }
}
