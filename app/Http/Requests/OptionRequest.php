<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OptionRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->canManageAllOptions() ||
            auth()->user()->canManageOwnOptions();
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'school_id' => ['required', 'exists:schools,id']
        ];
    }
}
