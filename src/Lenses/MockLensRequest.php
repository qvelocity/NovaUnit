<?php

namespace JoshGaber\NovaUnit\Lenses;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Laravel\Nova\Http\Requests\LensRequest;

class MockLensRequest extends LensRequest
{
    public bool $withFilters;
    public bool $withOrdering;

    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

        $this->withFilters = false;
        $this->withOrdering = false;
    }

    public function withFilters(Builder $query): Builder
    {
        $this->withFilters = true;

        return $query;
    }

    public function withOrdering(Builder $query, $defaultCallback = null): Builder
    {
        $this->withOrdering = true;

        return $query;
    }
}
