<?php

namespace Realty\Interfaces;

use Markable\Interfaces\HasViewsInterface;

interface ViewsManagerInterface
{
    /**
     * @param  HasViewsInterface  $model
     * @return void
     */
    public function view(HasViewsInterface $model): void;
}
