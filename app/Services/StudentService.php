<?php

namespace App\Services;

use App\Models\Classe;
use App\Models\Student;
use App\Models\User;
use App\Models\School;
use App\Models\Option;
use App\Models\Promotion;
use Illuminate\Support\Str;

class StudentService
{
    public function getFormData(?Student $student = null): array
    {
        $user = auth()->user();

        if ($user->role->name === 'Super Administrateur') {
            $availableStudentUsers = User::role('Élève')->whereDoesntHave('student')->get();
            $schools = School::all();
            $classes = Classe::all();
            $options = Option::all();
            $promotions = Promotion::all();
        } else {
            $availableStudentUsers = User::role('Élève')
                ->where('school_id', $user->school_id)
                ->whereDoesntHave('student')
                ->get();
            $schools = School::where('id', $user->school_id)->get();
            $classes = Classe::where('school_id', $user->school_id)->get();
            $options = Option::where('school_id', $user->school_id)->get();
            $promotions = Promotion::where('school_id', $user->school_id)->get();
        }

        return compact('student', 'availableStudentUsers', 'schools', 'classes', 'options', 'promotions');
    }

    public function createStudent(array $data): Student
    {
        $user = User::findOrFail($data['user_id']);

        return Student::create([
            'user_id' => $user->id,
            'registration_number' => $this->generateRegistrationNumber($user),
            'school_id' => $user->school_id,
            'class_id' => $data['class_id'],
            'option_id' => $data['option_id'] ?? null,
            'promotion_id' => $data['promotion_id']
        ]);
    }

    public function updateStudent(Student $student, array $data): Student
    {
        $student->update([
            'class_id' => $data['class_id'],
            'option_id' => $data['option_id'] ?? null,
            'promotion_id' => $data['promotion_id']
        ]);

        return $student;
    }

    public function deleteStudent(Student $student): void
    {
        $student->histories()->delete();
        $student->delete();
    }

    private function generateRegistrationNumber(User $user): string
    {
        // Initiales du nom (2 premières lettres)
        $namePart = Str::upper(Str::substr($user->name, 0, 2));

        // 2 premières lettres de l'école
        $schoolPart = Str::upper(Str::substr($user->school->name, 0, 2));

        // Année actuelle
        $year = date('Y');

        // ID incrémenté avec padding
        $lastId = Student::max('id') + 1;
        $idPart = str_pad($lastId, 4, '0', STR_PAD_LEFT);

        return $namePart . $schoolPart . $year . $idPart;
    }
}
