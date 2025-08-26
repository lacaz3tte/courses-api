<?php

namespace App\Filters;

use App\Core\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class ApplicationFilter extends Filter
{
    protected function email(string $value): Builder
    {
        return $this->builder->whereHas('user', function (Builder $q) use ($value){
            return $q->where('email', $value);
        });
    }

    protected function course(string $value): Builder
    {
        return $this->builder->whereHas('course', function (Builder $q) use ($value) {
            return $q->where('id', $value);
        });
    }
}
