<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Builder;

trait Searchable
{
    /**
     * Add search function to the model query
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $searchableFields
     * @param ?string $searchValue
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchable(
        Builder $query,
        array $searchableFields,
        ?string $searchValue = null
    ): Builder {
        $searchValue ??= request('search');

        $searchValue = trim($searchValue);

        if (!$searchValue) {
            return $query;
        }

        $query->where(function ($q) use ($searchValue, $searchableFields) {
            foreach ($searchableFields as $searchableKey) {
                $this->addSearchableKey($q, $searchableKey, $searchValue);
            }
        });

        return $query;
    }

    /**
     * Add the searchable key to the query builder
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param callable|string $searchableKey
     * @param string $searchValue
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function addSearchableKey(Builder &$query, $searchableKey, string $searchValue): Builder
    {
        if ($searchableKey instanceof \Closure) {
            return $query->orWhere($searchableKey($query, $searchValue));
        }

        $searchableKey = explode('.', $searchableKey);

        $column = $searchableKey[count($searchableKey) - 1];
        $relations = implode('.', array_slice($searchableKey, 0, -1));

        $arg = "%$searchValue%";
        $operator = 'LIKE';

        if (count($searchableKey) === 1) {
            // no relations
            return $query->orWhere($column, $operator, $arg);
        }

        return $query->orWhereHas(
            $relations,
            fn ($q) => $q->where($column, $operator, $arg)
        );
    }
}
