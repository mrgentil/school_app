<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
{
    return [
        'name' => 'required|string|max:255',
        'code' => 'nullable|string|max:50',
        'description' => 'nullable|string',
        'class_ids' => 'required|array',
        'class_ids.*' => 'exists:classes,id',
        'school_id' => auth()->user()->role->name === 'Super Administrateur'
            ? 'required|exists:schools,id'
            : 'nullable|exists:schools,id',
    ];
}
}
