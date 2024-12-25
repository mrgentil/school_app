<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Role;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true; // L'autorisation est gérée par les policies
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', Rule::in(['Masculin', 'Féminin'])],
            'adress' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'max:20'],
            'role_id' => ['required', 'exists:roles,id'],
            'school_id' => ['required', 'exists:schools,id'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];

        // Règle différente pour l'email selon création ou modification
        $emailRule = ['required', 'string', 'email', 'max:255'];
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $emailRule[] = Rule::unique('users')->ignore($this->user);
        } else {
            $emailRule[] = Rule::unique('users');
        }
        $rules['email'] = $emailRule;

        // Règle pour le mot de passe uniquement en création
        if ($this->isMethod('POST')) {
            $rules['password'] = ['sometimes', 'string', 'min:8'];
        }

        return $rules;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'nom',
            'first_name' => 'prénom',
            'last_name' => 'nom de famille',
            'gender' => 'genre',
            'adress' => 'adresse',
            'phone' => 'téléphone',
            'email' => 'adresse email',
            'role_id' => 'rôle',
            'school_id' => 'école',
            'avatar' => 'photo de profil',
            'password' => 'mot de passe',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'required' => 'Le champ :attribute est obligatoire.',
            'string' => 'Le champ :attribute doit être une chaîne de caractères.',
            'max' => 'Le champ :attribute ne doit pas dépasser :max caractères.',
            'email' => 'Le champ :attribute doit être une adresse email valide.',
            'unique' => 'Cette :attribute est déjà utilisée.',
            'exists' => 'Le :attribute sélectionné est invalide.',
            'image' => 'Le fichier doit être une image.',
            'mimes' => 'Le fichier doit être de type : :values.',
            'max.file' => 'L\'image ne doit pas dépasser :max kilo-octets.',
            'regex' => 'Le format du :attribute est invalide.',
            'min' => 'Le :attribute doit contenir au moins :min caractères.',
            'gender.in' => 'Le genre doit être soit M soit F.',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        if ($this->phone) {
            $this->merge([
                'phone' => preg_replace('/[^0-9+]/', '', $this->phone)
            ]);
        }
    }

    /**
     * Configure the validator instance.
     *
     * @param \Illuminate\Validation\Validator $validator
     * @return void
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if ($this->isMethod('POST') || $this->isMethod('PUT')) {
                $this->validateRoleAssignment($validator);
            }
        });
    }

    /**
     * Validate role assignment based on user permissions
     *
     * @param \Illuminate\Validation\Validator $validator
     * @return void
     */
    protected function validateRoleAssignment($validator): void
    {
        $currentUser = auth()->user();

        if ($currentUser->hasRole('Administrateur')) {
            $superAdminRole = Role::where('name', 'Super Administrateur')->first();

            if ($this->role_id == $superAdminRole->id) {
                $validator->errors()->add(
                    'role_id',
                    'Vous ne pouvez pas assigner le rôle de Super Administrateur.'
                );
            }

            if ($this->school_id != $currentUser->school_id) {
                $validator->errors()->add(
                    'school_id',
                    'Vous ne pouvez gérer que les utilisateurs de votre école.'
                );
            }
        }
    }
}
