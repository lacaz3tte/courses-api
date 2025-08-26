<?php

declare(strict_types=1);

namespace App\Core\Traits;

use App\Core\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

trait HasFilter
{
    public function scopeFilter(Builder $builder, Filter $filter): Builder
    {
        return $filter->apply($builder);
    }
}
