<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait SchoolSearchable
{
    // Implémentez votre logique ici
    public function scopeSearch(Builder $query, array $searchParams): Builder
    {
        foreach ($searchParams as $field => $value) {
            if ($value) {
                if ($field == 'name') {
                    $query->where(function ($q) use ($value) {
                        $q->where('name', 'LIKE', "%{$value}%");
                    });
                }
            }
        }

        return $query;
    }
}
