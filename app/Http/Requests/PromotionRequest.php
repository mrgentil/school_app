<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PromotionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return auth()->user()->canManageAllPromotions() ||
            auth()->user()->canManageOwnPromotions();
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'school_id' => ['required', 'exists:schools,id']
        ];
    }
}
