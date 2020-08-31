<?php

namespace App\Base;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Repository
{
    private $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Creates a new query builder instance.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function newQueryInstance(): Builder
    {
        return $this->model->newInstance()->query();
    }

    /**
     * Find a model using the given values.
     *
     * @param array $values
     *
     * @return Model|null
     */
    public function findBy(array $values): ?Model
    {
        return $this->newQueryInstance()->where($values)->first();
    }

    /**
     * @param int      $id
     * @param \Closure $modifier You can add more conditions here: function ($query) {...}
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findOrFail(int $id, \Closure $modifier = null): Model
    {
        $query = $this->newQueryInstance();

        if ($modifier) {
            call_user_func_array($modifier, [$query]);
        }

        return $query->findOrFail($id);
    }

    /**
     * Find a model using the given values or throw exception if not found.
     *
     * @param array $values
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findByOrFail(array $values): Model
    {
        $query = $this->newQueryInstance();

        return $query->where($values)->firstOrFail();
    }

    /**
     * Find a model using its id.
     *
     * @param string $id
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function findById(string $id): ?Model
    {
        return $this->findBy(['id' => $id]);
    }

    /**
     * Find a model using its id or throw exception if not found.
     *
     * @param string $id
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findByIdOrFail(string $id): Model
    {
        return $this->findByOrFail(['id' => $id]);
    }

    /**
     * Get many entities (all) based on request data and filters used..
     *
     * @param array $request
     * @param Filter|null $filter
     * @param \Closure $modifier You can add more conditions here: function ($query) {...}
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getMany(array $request = [], Filter $filter = null, \Closure $modifier = null)
    {
        return $this->buildFilteredQuery($request, $filter, $modifier)->get();
    }

    /**
     * Get many entities paginated based on request data and filters used..
     *
     * @param array $request
     * @param Filter|null $filter
     * @param \Closure $modifier    You can add more conditions here: function ($query) {...}
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getManyPaginate(array $request = [], Filter $filter = null, \Closure $modifier = null): LengthAwarePaginator
    {
        $perPage = config('paginator.page_size', 20);

        return $this->buildFilteredQuery($request, $filter, $modifier)->paginate($perPage);
    }

    /**
     * Build query with filter and modifier.
     *
     * @param array $request
     * @param \App\Base\Filter $filter
     * @param \Closure $modifier
     *
     * @return Builder
     */
    protected function buildFilteredQuery(array $request = [], Filter $filter = null, \Closure $modifier = null): Builder
    {
        return $this->buildFilteredQueryFrom($this->newQueryInstance(), $request, $filter, $modifier);
    }

    /**
     * Prepare base query for using.
     *
     * @param Builder $query
     * @param array $request
     * @param Filter|null $filter
     * @param \Closure $modifier    You can add more conditions here: function ($query) {...}
     *
     * @return Builder
     */
    protected function buildFilteredQueryFrom(Builder $query, array $request = [], Filter $filter = null, \Closure $modifier = null): Builder
    {
        if (null !== $filter) {
            $query = $filter->apply($query, $request);
        }

        if (null !== $modifier) {
            call_user_func_array($modifier, [$query]);
        }

        return $query;
    }
}
