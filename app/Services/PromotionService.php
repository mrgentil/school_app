<?php

namespace App\Services;

use App\Models\Promotion;
use App\Models\Student;
use App\Models\StudentHistory;
use App\Models\Classe;
use Illuminate\Support\Facades\DB;

class PromotionService
{
    // Vos méthodes existantes
    public function getPromotionsList($currentUser, $filters = [])
    {
        $query = Promotion::with(['school']);

        if ($currentUser->hasRole('Administrateur')) {
            $query->whereHas('school', function ($q) use ($currentUser) {
                $q->where('id', $currentUser->school_id);
            });
        }

        if (!empty($filters['name'])) {
            $query->where('name', 'LIKE', "%{$filters['name']}%");
        }

        if (!empty($filters['school'])) {
            $query->whereHas('school', function ($q) use ($filters) {
                $q->where('name', 'LIKE', "%{$filters['school']}%");
            });
        }

        return $query->latest()->paginate(15);
    }

    public function store(array $data, $user)
    {
        return Promotion::create([
            'name' => $data['name'],
            'school_id' => $data['school_id'],
            'created_by' => $user->id
        ]);
    }

    public function update(Promotion $promotion, array $data)
    {
        $promotion->update($data);
        return $promotion;
    }

    public function delete(Promotion $promotion)
    {
        return $promotion->delete();
    }

    // Nouvelles méthodes pour la promotion des élèves
    public function promoteStudents(array $studentIds, int $targetClassId, string $academicYear, string $promotionType)
    {
        try {
            DB::beginTransaction();

            $targetClass = Classe::findOrFail($targetClassId);
            $promotion = $this->createPromotionRecord($targetClass, $academicYear);

            foreach ($studentIds as $studentId) {
                $student = Student::findOrFail($studentId);

                if ($promotionType === 'automatic' && !$this->canBePromotedAutomatically($student)) {
                    continue;
                }

                $this->promoteStudent($student, $targetClass, $promotion, $academicYear);
            }

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function createPromotionRecord(Classe $targetClass, string $academicYear): Promotion
    {
        return Promotion::create([
            'name' => "Promotion {$academicYear}",
            'school_id' => $targetClass->school_id,
            'academic_year' => $academicYear,
            'created_by' => auth()->id()
        ]);
    }

    private function canBePromotedAutomatically(Student $student): bool
    {
        $currentHistory = $student->histories()
            ->where('status', 'active')
            ->first();

        if (!$currentHistory) {
            return false;
        }

        return $currentHistory->average_score >= 10
            && $currentHistory->decision === 'Admis';
    }

    private function promoteStudent(Student $student, Classe $targetClass, Promotion $promotion, string $academicYear): void
    {
        // Fermer l'historique actuel
        $student->histories()
            ->where('status', 'active')
            ->update([
                'status' => 'inactive',
                'end_date' => now(),
                'promotion_id' => $promotion->id
            ]);

        // Créer un nouvel historique
        StudentHistory::create([
            'student_id' => $student->id,
            'school_id' => $student->school_id,
            'class_id' => $targetClass->id,
            'promotion_id' => $promotion->id,
            'academic_year' => $academicYear,
            'semester' => 'Semestre 1',
            'status' => 'active',
            'start_date' => now(),
            'decision' => 'En cours'
        ]);

        // Mettre à jour la classe de l'élève
        $student->update([
            'class_id' => $targetClass->id,
            'current_promotion_id' => $promotion->id
        ]);
    }

    public function getEligibleStudents($schoolId, $currentAcademicYear)
    {
        return Student::with(['user', 'class', 'histories' => function ($query) {
            $query->where('status', 'active');
        }])
            ->where('school_id', $schoolId)
            ->whereHas('histories', function ($query) {
                $query->where('status', 'active')
                    ->where('decision', 'Admis')
                    ->where('average_score', '>=', 10);
            })
            ->get();
    }

    public function getPromotionHistory($promotionId)
    {
        return StudentHistory::with(['student.user', 'class', 'promotion'])
            ->where('promotion_id', $promotionId)
            ->get();
    }
}
