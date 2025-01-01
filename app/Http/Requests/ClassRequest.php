<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'section' => ['nullable', 'string', 'max:255'],
            'level' => ['required', 'integer', 'min:1'],
            'option_id' => ['nullable', 'exists:options,id'],
        ];

        // Ajouter school_id uniquement pour Super Administrateur
        if (auth()->user()->role->name === 'Super Administrateur') {
            $rules['school_id'] = ['required', 'exists:schools,id'];
        }

        return $rules;
    }

    protected function prepareForValidation()
    {
        // Définir les valeurs par défaut
        $this->merge([
            'level' => $this->level ?? 1,
            'school_id' => auth()->user()->role->name === 'Super Administrateur'
                ? $this->school_id
                : auth()->user()->school_id
        ]);
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom de la classe est requis',
            'level.required' => 'Le niveau est requis',
            'level.integer' => 'Le niveau doit être un nombre',
            'level.min' => 'Le niveau minimum est 1',
            'school_id.required' => "L'école est requise",
            'school_id.exists' => "L'école sélectionnée n'existe pas",
            'option_id.exists' => "L'option sélectionnée n'existe pas",
        ];
    }
}
