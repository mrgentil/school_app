<?php

namespace App\Services;

use App\Models\Option;

class OptionService
{
    public function getOptionsForUser($user)
    {
        if ($user->canManageAllOptions()) {
            return Option::with(['creator', 'school'])->latest()->get();
        }

        return Option::with(['creator', 'school'])
            ->where('created_by', $user->id)
            ->latest()
            ->get();
    }

    public function store(array $data, $user)
    {
        return Option::create([
            'name' => $data['name'],
            'school_id' => $data['school_id'],
            'created_by' => $user->id
        ]);
    }

    public function update(Option $option, array $data)
    {
        $option->update($data);
        return $option;
    }

    public function delete(Option $option)
    {
        return $option->delete();
    }
}
