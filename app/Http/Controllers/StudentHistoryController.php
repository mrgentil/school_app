<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Option;
use App\Models\School;
use App\Models\Student;
use App\Models\StudentHistory;
use Illuminate\Http\Request;
use App\Http\Requests\StudentHistoryRequest;
use Carbon\Carbon;

class StudentHistoryController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', StudentHistory::class);

        $user = auth()->user();

        // Récupération des écoles pour le filtre (uniquement pour Super Admin)
        $schools = $user->role->name === 'Super Administrateur' ? School::all() : collect([]);

        $histories = StudentHistory::with(['student.user', 'school', 'class', 'option'])
            // Filtre par recherche
            ->when($request->search, function($query) use ($request) {
                return $query->whereHas('student.user', function($q) use ($request) {
                    $q->where('name', 'like', "%{$request->search}%")
                        ->orWhere('first_name', 'like', "%{$request->search}%");
                })->orWhereHas('student', function($q) use ($request) {
                    $q->where('registration_number', 'like', "%{$request->search}%");
                });
            })
            // Filtre par école
            ->when($request->school_id, function($query) use ($request) {
                return $query->where('school_id', $request->school_id);
            })
            // Filtre par école pour les administrateurs
            ->when($user->role->name === 'Administrateur', function($query) use ($user) {
                return $query->where('school_id', $user->school_id);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('students-stories.index', compact('histories', 'schools'));
    }

    protected function redirectToIndex($message = 'Opération réussie')
    {
        return redirect()
            ->route('histories.index')
            ->with('success', $message);
    }

    public function create()
    {
        $this->authorize('create', StudentHistory::class);

        $students = Student::with('user')
            ->when(auth()->user()->role->name !== 'Super Administrateur', function ($query) {
                return $query->where('school_id', auth()->user()->school_id);
            })
            ->get();

        $classes = Classe::when(auth()->user()->role->name !== 'Super Administrateur', function ($query) {
            return $query->where('school_id', auth()->user()->school_id);
        })
            ->get();

        $options = Option::when(auth()->user()->role->name !== 'Super Administrateur', function ($query) {
            return $query->where('school_id', auth()->user()->school_id);
        })
            ->get();

        return view('students-stories.form', compact('students', 'classes', 'options'));
    }

    public function store(StudentHistoryRequest $request)
    {
        $this->authorize('create', StudentHistory::class);

        $student = Student::findOrFail($request->student_id);

        // Fermer l'historique actif précédent si existe
        StudentHistory::where('student_id', $student->id)
            ->where('status', 'active')
            ->update([
                'status' => 'inactive',
                'end_date' => now()
            ]);

        StudentHistory::create([
            'student_id' => $student->id,
            'school_id' => $student->school_id,
            'class_id' => $request->class_id,
            'option_id' => $request->option_id,
            'academic_year' => $request->academic_year,
            'semester' => $request->semester,
            'average_score' => $request->average_score,
            'rank' => $request->rank,
            'decision' => $request->decision,
            'conduct_grade' => $request->conduct_grade,
            'attendance_record' => $request->attendance_record,
            'teacher_remarks' => $request->teacher_remarks,
            'start_date' => now(),
            'status' => 'active'
        ]);

        return redirect()
            ->route('histories.index')
            ->with('success', 'Historique ajouté avec succès');
    }

    public function edit(StudentHistory $history)
    {
        $this->authorize('update', $history);

        $students = Student::with('user')
            ->when(auth()->user()->role->name !== 'Super Administrateur', function ($query) {
                return $query->where('school_id', auth()->user()->school_id);
            })
            ->get();

        $classes = Classe::when(auth()->user()->role->name !== 'Super Administrateur', function ($query) {
            return $query->where('school_id', auth()->user()->school_id);
        })
            ->get();

        $options = Option::when(auth()->user()->role->name !== 'Super Administrateur', function ($query) {
            return $query->where('school_id', auth()->user()->school_id);
        })
            ->get();

        return view('students-stories.form', compact('history', 'students', 'classes', 'options'));
    }

    public function update(StudentHistoryRequest $request, StudentHistory $history)
    {
        $this->authorize('update', $history);

        $history->update([
            'class_id' => $request->class_id,
            'option_id' => $request->option_id,
            'academic_year' => $request->academic_year,
            'semester' => $request->semester,
            'average_score' => $request->average_score,
            'rank' => $request->rank,
            'decision' => $request->decision,
            'conduct_grade' => $request->conduct_grade,
            'attendance_record' => $request->attendance_record,
            'teacher_remarks' => $request->teacher_remarks
        ]);

        return redirect()
            ->route('histories.index')
            ->with('success', 'Historique mis à jour avec succès');
    }

    public function destroy(StudentHistory $history)
    {
        $this->authorize('delete', $history);

        $history->delete();

        return redirect()
            ->route('histories.index')
            ->with('success', 'Historique supprimé avec succès');
    }

    public function show(StudentHistory $history)
    {
        $this->authorize('view', $history);

        $history->load(['student.user', 'school', 'class', 'option']);

        return view('students-stories.show', compact('history'));
    }
}
