<?php

namespace App\Services;

use App\Models\Subject;
use Illuminate\Support\Facades\DB;

class SubjectService
{
    public function create(array $data): Subject
    {
        return DB::transaction(function () use ($data) {
            return Subject::create([
                'name' => $data['name'],
                'code' => $data['code'] ?? null,
                'description' => $data['description'] ?? null,
                'school_id' => $data['school_id'],
                'created_by' => auth()->id(),
            ]);
        });
    }

    public function update(Subject $subject, array $data): bool
    {
        return DB::transaction(function () use ($subject, $data) {
            return $subject->update([
                'name' => $data['name'],
                'code' => $data['code'] ?? $subject->code,
                'description' => $data['description'] ?? $subject->description,
                'school_id' => $data['school_id'],
            ]);
        });
    }

    public function assignTeachers(Subject $subject, array $data): void
    {
        DB::transaction(function () use ($subject, $data) {
            $subject->teachers()->wherePivot('academic_year', $data['academic_year'])->detach();

            foreach ($data['teachers'] as $teacherData) {
                $subject->teachers()->attach($teacherData['teacher_id'], [
                    'class_id' => $teacherData['class_id'],
                    'school_id' => $subject->school_id,
                    'academic_year' => $data['academic_year'],
                ]);
            }
        });
    }

    public function duplicate(Subject $subject): Subject
    {
        return DB::transaction(function () use ($subject) {
            $newSubject = $subject->replicate();
            $newSubject->name = $subject->name . ' (copie)';
            $newSubject->code = $subject->code . '-copy';
            $newSubject->created_by = auth()->id();
            $newSubject->save();

            return $newSubject;
        });
    }
}
