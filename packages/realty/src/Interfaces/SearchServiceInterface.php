<?php

namespace Realty\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Realty\Models\Ad;
use Search\Exceptions\SearchException;

interface SearchServiceInterface
{
    public const SEARCHABLE = [
        'ads' => Ad::class,
    ];

    /**
     * @param  string  $string
     * @param  string  $searchable
     * @param  int|null  $perPage
     * @return Collection|LengthAwarePaginator
     *
     * @throws SearchException
     */
    public function search(string $string, string $searchable, int $perPage = null): Collection|LengthAwarePaginator;
}
