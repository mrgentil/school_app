<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Searchable
{
    public function scopeSearch(Builder $query, array $searchParams): Builder
    {
        foreach ($searchParams as $field => $value) {
            if ($value) {
                switch ($field) {
                    case 'id':
                        $query->where('id', 'LIKE', "%{$value}%");
                        break;
                    case 'name':
                        $query->where(function ($q) use ($value) {
                            $q->where('name', 'LIKE', "%{$value}%")
                                ->orWhere('first_name', 'LIKE', "%{$value}%")
                                ->orWhere('last_name', 'LIKE', "%{$value}%");
                        });
                        break;
                    case 'school':
                        $query->whereHas('school', function ($q) use ($value) {
                            $q->where('name', 'LIKE', "%{$value}%");
                        });
                        break;
                }
            }
        }

        return $query;
    }
}
