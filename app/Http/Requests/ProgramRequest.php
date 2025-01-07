<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProgramRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->canManagePrograms();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'school_id' => 'nullable|exists:schools,id',
            'file' => 'required|file|mimes:pdf,doc,docx,xlsx|max:2048', // Ajout de la validation du fichier
        ];
    }

}
