<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'class_id' => ['required', 'exists:classes,id'],
            'option_id' => ['nullable', 'exists:options,id'],
            'promotion_id' => ['required', 'exists:promotions,id'],
            'notes' => ['nullable', 'string', 'max:500'],
        ];

        // Ajouter la validation user_id uniquement pour la création
        if ($this->isMethod('POST')) {
            $rules['user_id'] = ['required', 'exists:users,id', 'unique:students,user_id'];
        }

        return $rules;
    }
}
