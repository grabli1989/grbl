<?php

namespace Search\Services;

use Illuminate\Config\Repository;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Laravel\Scout\Searchable;
use Realty\Interfaces\SearchServiceInterface;
use Search\Exceptions\SearchException;

class SearchService implements SearchServiceInterface
{
    private Repository $modules;

    /**
     * @throws BindingResolutionException
     */
    public function __construct()
    {
        $this->modules = app()->make('modules');
    }

    /**
     * @param  string  $string
     * @param  string  $searchable
     * @param  int|null  $perPage
     * @return Collection|LengthAwarePaginator
     *
     * @throws SearchException
     */
    public function search(string $string, string $searchable, int $perPage = null): Collection|LengthAwarePaginator
    {
        $perPage = $perPage ?? $this->modules->get('search.paginate.perPage');

        if (! isset(self::SEARCHABLE[$searchable])) {
            throw SearchException::searchableException($searchable);
        }

        /** @var Searchable $class */
        $class = self::SEARCHABLE[$searchable];

        return $class::search($string)->paginate($perPage);
    }
}
