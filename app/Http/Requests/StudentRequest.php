<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'class_id' => ['required', 'exists:classes,id'],
            'option_id' => ['nullable', 'exists:options,id'],
            'promotion_id' => ['required', 'exists:promotions,id'],
        ];

        if ($this->isMethod('POST')) {
            $rules['user_id'] = ['required', 'exists:users,id', 'unique:students,user_id'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'Veuillez sélectionner un élève',
            'user_id.exists' => 'L\'élève sélectionné n\'existe pas',
            'user_id.unique' => 'Cet élève a déjà un profil étudiant',
            'class_id.required' => 'Veuillez sélectionner une classe',
            'class_id.exists' => 'La classe sélectionnée n\'existe pas',
            'option_id.exists' => 'L\'option sélectionnée n\'existe pas',
            'promotion_id.required' => 'Veuillez sélectionner une promotion',
            'promotion_id.exists' => 'La promotion sélectionnée n\'existe pas',
        ];
    }
}
