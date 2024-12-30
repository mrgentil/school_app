<?php

namespace App\Services;

use App\Models\Student;
use App\Models\StudentHistory;
use App\Models\User;
use Carbon\Carbon;

class StudentService
{
    public function createStudent(array $data): Student
    {
        // Récupérer l'utilisateur élève
        $studentUser = User::findOrFail($data['user_id']);

        // Générer le numéro d'inscription
        $registrationNumber = $this->generateRegistrationNumber($studentUser);

        // Créer l'étudiant
        $student = Student::create([
            'user_id' => $studentUser->id,
            'registration_number' => $registrationNumber,
            'school_id' => $studentUser->school_id,
            'class_id' => $data['class_id'],
            'option_id' => $data['option_id'] ?? null,
            'promotion_id' => $data['promotion_id']
        ]);

        // Créer l'historique initial
        $this->createHistory($student, $data);

        return $student;
    }

    public function updateStudent(Student $student, array $data): Student
    {
        // Vérifier s'il y a des changements dans les données scolaires
        $hasChanges = $this->hasSchoolInfoChanges($student, $data);

        // Si il y a des changements, créer un nouvel historique
        if ($hasChanges) {
            // Fermer l'historique actuel
            $this->closeCurrentHistory($student);
            // Créer un nouvel historique
            $this->createHistory($student, $data);
        }

        // Mettre à jour l'étudiant
        $student->update([
            'class_id' => $data['class_id'],
            'option_id' => $data['option_id'] ?? null,
            'promotion_id' => $data['promotion_id']
        ]);

        return $student;
    }

    private function generateRegistrationNumber($user): string
    {
        // Prendre les 2 premières lettres du nom et prénom
        $namePart = strtoupper(substr($user->name, 0, 2) . substr($user->first_name, 0, 2));

        // Prendre les 2 premières lettres de l'école
        $schoolPart = strtoupper(substr($user->school->name, 0, 2));

        // Année actuelle
        $year = date('Y');

        // ID incrémenté avec padding
        $lastId = Student::max('id') + 1;
        $idPart = str_pad($lastId, 4, '0', STR_PAD_LEFT);

        return $namePart . $schoolPart . $year . $idPart;
    }

    private function createHistory(Student $student, array $data): void
    {
        StudentHistory::create([
            'student_id' => $student->id,
            'school_id' => $student->school_id,
            'class_id' => $data['class_id'],
            'option_id' => $data['option_id'] ?? null,
            'promotion_id' => $data['promotion_id'],
            'start_date' => Carbon::now(),
            'status' => 'active',
            'notes' => $data['notes'] ?? null
        ]);
    }

    private function closeCurrentHistory(Student $student): void
    {
        StudentHistory::where('student_id', $student->id)
            ->where('status', 'active')
            ->whereNull('end_date')
            ->update([
                'end_date' => Carbon::now(),
                'status' => 'inactive'
            ]);
    }

    private function hasSchoolInfoChanges(Student $student, array $data): bool
    {
        return $student->class_id != $data['class_id'] ||
            $student->option_id != ($data['option_id'] ?? null) ||
            $student->promotion_id != $data['promotion_id'];
    }
}
