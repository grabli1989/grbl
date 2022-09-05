<?php

namespace Markable\Managers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Maize\Markable\Models\Favorite;
use Realty\Interfaces\FavoriteServiceInterface;
use Realty\Interfaces\HasFavoritesInterface;
use User\Models\User;

class FavoritesManager implements FavoriteServiceInterface
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
     * @param  HasFavoritesInterface  $model
     * @return \Maize\Markable\Mark|Favorite
     *
     * @throws \Maize\Markable\Exceptions\InvalidMarkValueException
     */
    public function add(HasFavoritesInterface $model): Favorite
    {
        return Favorite::add($model, $this->user);
    }

    /**
     * @param  HasFavoritesInterface  $model
     * @return void
     */
    public function remove(HasFavoritesInterface $model): void
    {
        Favorite::remove($model, $this->user);
    }

    /**
     * @param  HasFavoritesInterface  $model
     * @return Favorite|Collection
     */
    public function toggle(HasFavoritesInterface $model): Favorite|Collection
    {
        return Favorite::toggle($model, $this->user);
    }

    /**
     * @param  HasFavoritesInterface  $model
     * @return bool
     */
    public function has(HasFavoritesInterface $model): bool
    {
        return Favorite::has($model, $this->user);
    }

    /**
     * @param  HasFavoritesInterface  $model
     * @return int
     */
    public function count(HasFavoritesInterface $model): int
    {
        return Favorite::count($model);
    }
}
