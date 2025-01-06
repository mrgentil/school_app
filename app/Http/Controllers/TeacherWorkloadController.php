<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherWorkloadController extends Controller
{
    public function workloadOverview(Request $request)
    {
        $academicYear = $request->input('academic_year', now()->format('Y'));
        $user = auth()->user();

        // Vérifier le rôle de l'utilisateur
        if ($user->hasRole('Super Administrateur')) {
            // Si Super Administrateur, voir tous les enseignants
            $teachers = Teacher::with('subjects')->get();
        } elseif ($user->hasRole('Administrateur')) {
            // Si Administrateur, voir uniquement les enseignants de son école
            $teachers = Teacher::with('subjects')->where('school_id', $user->school_id)->get();
        } else {
            // Si aucun rôle, renvoyer une erreur ou afficher un message
            return abort(403, 'Vous n\'avez pas l\'autorisation pour accéder à cette page.');
        }

        // Générer les données pour la vue
        $teachers = $teachers->map(function ($teacher) use ($academicYear) {
            return [
                'id' => $teacher->id, // Ajoute l'identifiant
                'name' => $teacher->user->name,
                'totalWorkload' => $teacher->totalWorkload($academicYear),
                'isOverloaded' => $teacher->isOverloaded(20, $academicYear),
            ];
        });

        return view('teachers.workload', compact('teachers'));
    }


    public function update(Request $request, Teacher $teacher)
    {
        $user = auth()->user();

        if ($user->hasRole('Super Administrateur') || ($user->hasRole('Administrateur') && $teacher->school_id == $user->school_id)) {
            // Validation des données
            $validated = $request->validate([
                'hours_per_week' => 'required|numeric|min:0',
            ]);

            $academicYear = $request->input('academic_year', now()->format('Y'));

            // Mise à jour
            $updated = DB::table('subject_teacher')
                ->where('teacher_id', $teacher->id)
                ->where('academic_year', $academicYear)
                ->update(['hours_per_week' => $validated['hours_per_week']]);

            if ($updated === 0) {
                return back()->withErrors('Aucune donnée mise à jour. Vérifiez les associations et les données.');
            }

            return redirect()->route('workload.overview')->with('success', 'Charge horaire mise à jour avec succès.');
        } else {
            return abort(403, 'Vous n\'avez pas l\'autorisation pour effectuer cette modification.');
        }
    }


}
