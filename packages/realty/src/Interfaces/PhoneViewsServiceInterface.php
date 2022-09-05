<?php

namespace Realty\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Markable\Models\PhoneView;

interface PhoneViewsServiceInterface
{
    /**
     * @param  HasPhoneViewsInterface  $model
     * @return PhoneView
     *
     * @throws \Maize\Markable\Exceptions\InvalidMarkValueException
     */
    public function add(HasPhoneViewsInterface $model): PhoneView;

    /**
     * @param  HasPhoneViewsInterface  $model
     * @return void
     */
    public function remove(HasPhoneViewsInterface $model): void;

    /**
     * @param  HasPhoneViewsInterface  $model
     * @return PhoneView|Collection
     */
    public function toggle(HasPhoneViewsInterface $model): PhoneView|Collection;

    /**
     * @param  HasPhoneViewsInterface  $model
     * @return bool
     */
    public function has(HasPhoneViewsInterface $model): bool;

    /**
     * @param  HasPhoneViewsInterface  $model
     * @return int
     */
    public function count(HasPhoneViewsInterface $model): int;
}
