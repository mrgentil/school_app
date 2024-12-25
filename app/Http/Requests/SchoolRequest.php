<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SchoolRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasAnyRole(['Super Administrateur', 'Administrateur']);
    }

    public function rules(): array
    {
        $rules = [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('schools', 'name')->ignore($this->school),
            ],
            'adress' => 'required|string|max:255',
            'logo' => [
                $this->isMethod('PUT') ? 'nullable' : 'required',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:2048'
            ],
        ];

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom de l\'école est obligatoire.',
            'name.unique' => 'Ce nom d\'école existe déjà.',
            'adress.required' => 'L\'adresse est obligatoire.',
            'logo.image' => 'Le fichier doit être une image.',
            'logo.mimes' => 'Le logo doit être au format : jpeg, png, jpg ou gif.',
            'logo.max' => 'Le logo ne doit pas dépasser 2Mo.',
        ];
    }
}
