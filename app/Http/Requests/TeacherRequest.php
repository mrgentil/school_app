<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeacherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
{
    return [
        'user_id' => [
            'required',
            'exists:users,id',
            function ($attribute, $value, $fail) {
                $user = User::find($value);
                if (!$user || $user->role->name !== 'Professeur') {
                    $fail("L'utilisateur sélectionné doit avoir le rôle de professeur.");
                }

                // Vérifier si l'utilisateur n'est pas déjà professeur (sauf en édition)
                if (!$this->teacher && Teacher::where('user_id', $value)->exists()) {
                    $fail("Cet utilisateur est déjà assigné comme professeur.");
                }
            },
        ],
        'school_id' => 'required|exists:schools,id',
        'speciality' => 'nullable|string|max:255',
        'status' => 'nullable|in:active,inactive',
    ];
}
}
