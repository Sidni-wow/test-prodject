<?php

namespace App\Base;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

abstract class Filter
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * The Eloquent Query Builder instance.
     *
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $builder;

    /**
     * Forbidden columns for sorting operation.
     *
     * @var array
     */
    protected $nonSortableColumns = [];

    /**
     * Blacklisted methods cannot be called for filtering.
     *
     * @var array
     */
    private $blacklist = [
        'apply',
        'methodIsValid',
    ];

    /**
     * Filter constructior.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param string $column
     *
     * @throws \InvalidArgumentException
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function order(string $column): Builder
    {
        if (! in_array($column, $this->getSortableColumns())) {
            throw new \InvalidArgumentException('Sorting field name does not exist or forbidden to use.');
        }

        $direction = $this->request->query('sort', 'asc');

        if (! in_array($direction, ['asc', 'desc'])) {
            throw new \InvalidArgumentException('Invalid sorting direction value, "asc" or "desc" accepted only.');
        }

        return $this->builder->orderBy($column, $direction);
    }

    /**
     * Apply the filters to the Query Builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param array $filters
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Builder $builder, array $filters = null)
    {
        $this->builder = $builder;

        if (null === $filters) {
            $filters = $this->request->all();
        }

        try {
            foreach ($filters as $method => $value) {
                if (mb_strlen(trim($value)) === 0) {
                    continue;
                }

                $method = Str::camel($method, '_');

                if (! $this->methodIsValid($method)) {
                    continue;
                }

                $this->{$method}($value);
            }
        } catch (\Exception $e) {
            // Prevent error 500
            abort(400, $e->getMessage());
        }

        return $this->builder;
    }

    /**
     * @param string $value
     *
     * @return void
     */
    public function id(string $value): void
    {
        $this->builder->where('id', $value);
    }

    /**
     * Determines if the given method is valid.
     *
     * @param string $method
     *
     * @return bool
     */
    protected function methodIsValid($method): bool
    {
        if (! method_exists($this, $method)) {
            return false;
        }

        $reflection = new \ReflectionClass($this);
        $isPublic = $reflection->getMethod($method)->isPublic();

        return $isPublic && ! in_array($method, $this->blacklist);
    }

    /**
     * Fetch column names from model table (all by default).
     *
     * @return array
     */
    protected function getSortableColumns(): array
    {
        $class = $this->getModelClass();
        $defaultColumns = Schema::getColumnListing((new $class())->getTable()); // TODO make it more pretty

        return array_diff($defaultColumns, $this->nonSortableColumns);
    }

    /**
     * Get main model class used.
     *
     * @return string
     */
    abstract protected function getModelClass(): string;
}
