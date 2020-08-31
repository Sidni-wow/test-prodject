<?php

namespace App\Http\Filters;

use App\Base\Filter;
use App\Models\Film;

class FilmFilter extends Filter
{
    /**
     * {@inheritdoc}
     */
    protected function getModelClass(): string
    {
        return Film::class;
    }
}
