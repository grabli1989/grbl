<?php

namespace Realty\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Maize\Markable\Models\Favorite;

interface FavoriteServiceInterface
{
    /**
     * @param  HasFavoritesInterface  $model
     * @return Favorite
     *
     * @throws \Maize\Markable\Exceptions\InvalidMarkValueException
     */
    public function add(HasFavoritesInterface $model): Favorite;

    /**
     * @param  HasFavoritesInterface  $model
     * @return void
     */
    public function remove(HasFavoritesInterface $model): void;

    /**
     * @param  HasFavoritesInterface  $model
     * @return Favorite|Collection
     */
    public function toggle(HasFavoritesInterface $model): Favorite|Collection;

    /**
     * @param  HasFavoritesInterface  $model
     * @return bool
     */
    public function has(HasFavoritesInterface $model): bool;

    /**
     * @param  HasFavoritesInterface  $model
     * @return int
     */
    public function count(HasFavoritesInterface $model): int;
}
