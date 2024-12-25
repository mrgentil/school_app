<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->canManageAllClasses() ||
            auth()->user()->canManageOwnClasses();
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'school_id' => ['required', 'exists:schools,id']
        ];
    }
}
