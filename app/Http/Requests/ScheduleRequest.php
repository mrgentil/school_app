<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à faire cette requête.
     */
    public function authorize(): bool
    {
        // Autoriser uniquement les utilisateurs ayant le rôle Super Administrateur ou Administrateur
        return auth()->check() && in_array(auth()->user()->role->name, ['Super Administrateur', 'Administrateur']);
    }

    /**
     * Règles de validation.
     */
    public function rules(): array
    {
        $user = auth()->user();

        $rules = [
            'day_of_week' => ['required', 'string', 'in:Lundi,Mardi,Mercredi,Jeudi,Vendredi,Samedi'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'class_id' => ['required', 'exists:classes,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
        ];

        // Validation pour le professeur
        $rules['teacher_id'] = [
            'required',
            'exists:users,id',
            function ($attribute, $value, $fail) use ($user) {
                $teacher = \App\Models\User::where('id', $value)
                    ->whereHas('role', function ($query) {
                        $query->where('name', 'Professeur');
                    });

                // Si l'utilisateur est Administrateur, ajouter une restriction par école
                if ($user->role->name === 'Administrateur') {
                    $teacher->where('school_id', $user->school_id);
                }

                if (!$teacher->exists()) {
                    $fail('Le professeur sélectionné n\'existe pas ou n\'est pas disponible pour votre école.');
                }
            },
        ];

        // Validation spécifique pour le Super Administrateur
        if ($user->role->name === 'Super Administrateur') {
            $rules['school_id'] = ['required', 'exists:schools,id'];
        }

        return $rules;
    }

    /**
     * Préparer les données pour la validation.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'school_id' => $this->determineSchoolId(),
        ]);
    }

    /**
     * Détermine l'ID de l'école pour la validation.
     */
    private function determineSchoolId(): ?int
    {
        $user = auth()->user();

        if ($user->role->name === 'Super Administrateur') {
            return $this->school_id; // Utilisé pour Super Administrateur (peut gérer plusieurs écoles)
        }

        // Pour un Administrateur, l'école est toujours celle de l'utilisateur connecté
        return $user->school_id;
    }

    /**
     * Messages de validation personnalisés.
     */
    public function messages(): array
    {
        return [
            'day_of_week.required' => 'Le jour de la semaine est requis.',
            'day_of_week.in' => 'Le jour de la semaine doit être un jour valide (Lundi, Mardi, etc.).',
            'start_time.required' => 'L\'heure de début est requise.',
            'start_time.date_format' => 'L\'heure de début doit être au format HH:MM.',
            'end_time.required' => 'L\'heure de fin est requise.',
            'end_time.date_format' => 'L\'heure de fin doit être au format HH:MM.',
            'end_time.after' => 'L\'heure de fin doit être après l\'heure de début.',
            'class_id.required' => 'La classe est requise.',
            'class_id.exists' => 'La classe sélectionnée n\'existe pas.',
            'subject_id.required' => 'La matière est requise.',
            'subject_id.exists' => 'La matière sélectionnée n\'existe pas.',
            'teacher_id.required' => 'Le professeur est requis.',
            'teacher_id.exists' => 'Le professeur sélectionné n\'existe pas.',
            'school_id.required' => 'L\'école est requise pour les Super Administrateurs.',
            'school_id.exists' => 'L\'école sélectionnée n\'existe pas.',
        ];
    }
}
