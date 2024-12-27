<?php

namespace App\Services;

use App\Models\Promotion;

class PromotionService
{
    public function getPromotionsList($currentUser, $filters = [])
    {
        $query = Promotion::with(['school']); // Assurez-vous d'avoir la relation school définie

        // Si l'utilisateur est administrateur, ne montrer que les promotions de son école
        if ($currentUser->hasRole('Administrateur')) {
            $query->whereHas('school', function($q) use ($currentUser) {
                $q->where('id', $currentUser->school_id);
            });
        }

        // Recherche par année/nom de promotion
        if (!empty($filters['name'])) {
            $query->where('name', 'LIKE', "%{$filters['name']}%");
        }

        // Recherche par nom d'école
        if (!empty($filters['school'])) {
            $query->whereHas('school', function($q) use ($filters) {
                $q->where('name', 'LIKE', "%{$filters['school']}%");
            });
        }

        return $query->latest()->paginate(15);
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
