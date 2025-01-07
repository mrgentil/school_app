<?php

namespace App\Services;

use App\Models\Program;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ProgramService
{
    public function getProgramList($currentUser, $filters = [])
    {
        $query = Program::with(['school']);

        if ($currentUser->role->name === 'Administrateur') {
            $query->where('school_id', $currentUser->school_id);
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

    public function store(array $data, User $user)
    {
        $filePath = isset($data['file']) ? $data['file']->store('programs', 'public') : null;

        return Program::create([
            'name' => $data['name'],
            'school_id' => $user->role->name === 'Super Administrateur'
                ? $data['school_id']
                : $user->school_id,
            'uploaded_by' => $user->id,
            'file_path' => $filePath,
            'file_type' => $filePath ? $data['file']->getClientOriginalExtension() : null,
        ]);
    }



    public function update(Program $program, array $data)
    {
        if (isset($data['file'])) {
            Storage::disk('public')->delete($program->file_path);
            $data['file_path'] = $data['file']->store('programs', 'public');
            $data['file_type'] = $data['file']->getClientOriginalExtension();
        }

        $program->update(array_filter($data));
        return $program;
    }

    public function delete(Program $program)
    {
        if ($program->file_path) {
            // Supprime le fichier si le chemin est défini
            Storage::disk('public')->delete($program->file_path);
        }

        // Supprime l'enregistrement du programme
        return $program->delete();
    }

}
