<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentHistoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'student_id' => ['required', 'exists:students,id'],
            'class_id' => ['required', 'exists:classes,id'],
            'option_id' => ['nullable', 'exists:options,id'],
            'academic_year' => ['required', 'string'],
            'semester' => ['required', 'in:Semestre 1,Semestre 2'],
            'average_score' => ['nullable', 'numeric', 'min:0', 'max:20'],
            'rank' => ['nullable', 'integer', 'min:1'],
            'decision' => ['required', 'in:En cours,Admis,Ajourné,Redouble'],
            'conduct_grade' => ['nullable', 'string'],
            'attendance_record' => ['nullable', 'string'],
            'teacher_remarks' => ['nullable', 'string'],
        ];
    }
}
