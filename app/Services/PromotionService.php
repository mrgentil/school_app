<?php

namespace App\Services;

use App\Models\Promotion;

class PromotionService
{
    public function getPromotionsForUser($user)
    {
        if ($user->canManageAllPromotions()) {
            return Promotion::with(['creator', 'school'])->latest()->get();
        }

        return Promotion::with(['creator', 'school'])
            ->where('created_by', $user->id)
            ->latest()
            ->get();
    }

    public function store(array $data, $user)
    {
        return Promotion::create([
            'name' => $data['name'],
            'school_id' => $data['school_id'],
            'created_by' => $user->id
        ]);
    }

    public function update(Promotion $promotion, array $data)
    {
        $promotion->update($data);
        return $promotion;
    }

    public function delete(Promotion $promotion)
    {
        return $promotion->delete();
    }
}
