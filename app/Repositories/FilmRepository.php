<?php

namespace App\Repositories;

use App\Base\Repository;
use App\Http\Filters\FilmFilter;
use App\Models\Film;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class FilmRepository extends Repository
{
    /**
     * Constructor.
     *
     * @param Film $model
     */
    public function __construct(Film $model)
    {
        parent::__construct($model);
    }

    /**
     * Get published films.
     *
     * @param array $request
     *
     * @param FilmFilter|null $filter
     * @return LengthAwarePaginator
     */
    public function getPublishedFilms(array $request = [], FilmFilter $filter = null): LengthAwarePaginator
    {
        $baseQuery = Film::onlyPublished()->onlyNotWatchSoon()->position();

        return $this->buildFilteredQueryFrom($baseQuery, $request, $filter, null)->paginate();
    }

    /**
     * Get published films.
     *
     * @param array $request
     *
     * @param FilmFilter|null $filter
     * @return LengthAwarePaginator
     */
    public function getWatchSoonFilms(array $request = [], FilmFilter $filter = null): LengthAwarePaginator
    {
        $baseQuery = Film::onlyPublished()->onlyWatchSoon()->position();

        return $this->buildFilteredQueryFrom($baseQuery, $request, $filter, null)->paginate();
    }

    /**
     * Get pagination films.
     *
     * @param array $request
     *
     * @param FilmFilter|null $filter
     * @return LengthAwarePaginator
     */
    public function getAllFilms(array $request = [], FilmFilter $filter = null): LengthAwarePaginator
    {
        $baseQuery = Film::query()->position();

        return $this->buildFilteredQueryFrom($baseQuery, $request, $filter, null)->paginate();
    }
}
