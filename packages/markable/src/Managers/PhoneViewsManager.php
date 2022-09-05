<?php

namespace Markable\Managers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Maize\Markable\Mark;
use Markable\Models\PhoneView;
use Realty\Interfaces\HasPhoneViewsInterface;
use Realty\Interfaces\PhoneViewsServiceInterface;
use User\Models\User;

class PhoneViewsManager implements PhoneViewsServiceInterface
{
    private User|null $user;

    /**
     * @param  Request  $request
     */
    public function __construct(Request $request)
    {
        $this->user = $request->user();
    }

    /**
     * @param  HasPhoneViewsInterface  $model
     * @return PhoneView|Mark
     *
     * @throws \Maize\Markable\Exceptions\InvalidMarkValueException
     */
    public function add(HasPhoneViewsInterface $model): PhoneView
    {
        return PhoneView::add($model, $this->user);
    }

    /**
     * @param  HasPhoneViewsInterface  $model
     * @return void
     */
    public function remove(HasPhoneViewsInterface $model): void
    {
        PhoneView::remove($model, $this->user);
    }

    /**
     * @param  HasPhoneViewsInterface  $model
     * @return PhoneView|Collection
     */
    public function toggle(HasPhoneViewsInterface $model): PhoneView|Collection
    {
        return PhoneView::toggle($model, $this->user);
    }

    /**
     * @param  HasPhoneViewsInterface  $model
     * @return bool
     */
    public function has(HasPhoneViewsInterface $model): bool
    {
        return PhoneView::has($model, $this->user);
    }

    /**
     * @param  HasPhoneViewsInterface  $model
     * @return int
     */
    public function count(HasPhoneViewsInterface $model): int
    {
        return PhoneView::count($model);
    }
}
