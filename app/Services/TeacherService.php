<?php

namespace App\Services;

use App\Models\Teacher;
use Illuminate\Support\Facades\DB;

class TeacherService
{
    public function create(array $data): Teacher
    {
        return DB::transaction(function () use ($data) {
            return Teacher::create([
                'user_id' => $data['user_id'],
                'school_id' => $data['school_id'],
                'speciality' => $data['speciality'] ?? null,
                'status' => $data['status'] ?? 'active',
            ]);
        });
    }

    public function update(Teacher $teacher, array $data): bool
    {
        return DB::transaction(function () use ($teacher, $data) {
            return $teacher->update([
                'speciality' => $data['speciality'] ?? $teacher->speciality,
                'school_id' => $data['school_id'] ?? $teacher->school_id,
                'status' => $data['status'] ?? $teacher->status,
            ]);
        });
    }

    public function assignSubjects(Teacher $teacher, array $data): void
    {
        DB::transaction(function () use ($teacher, $data) {
            // Détacher les anciennes matières pour cette année académique
            $teacher->subjects()->wherePivot('academic_year', $data['academic_year'])->detach();

            // Attacher les nouvelles matières
            foreach ($data['subjects'] as $subject) {
                $teacher->subjects()->attach($subject['subject_id'], [
                    'class_id' => $subject['class_id'],
                    'school_id' => $teacher->school_id,
                    'academic_year' => $data['academic_year']
                ]);
            }
        });
    }

    public function delete(Teacher $teacher): bool
    {
        return DB::transaction(function () use ($teacher) {
            return $teacher->delete();
        });
    }
}
