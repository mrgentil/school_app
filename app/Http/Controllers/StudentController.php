<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Models\Classe;
use App\Models\School;
use App\Models\Student;
use App\Models\User;
use App\Models\Option;
use App\Models\Promotion;
use App\Services\StudentService;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    protected $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
        $this->authorizeResource(Student::class, 'student');
    }

    public function index()
    {
        $user = auth()->user();

        // Récupérer les étudiants selon le rôle
        $students = Student::with(['user', 'school', 'class', 'option', 'promotion'])
            ->when($user->role->name === 'Administrateur', function ($query) use ($user) {
                $query->where('school_id', $user->school_id);
            })
            ->when(request('search'), function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('first_name', 'like', "%{$search}%");
                    })
                        ->orWhere('registration_number', 'like', "%{$search}%");
                });
            })
            ->when(request('school_id'), function ($query, $schoolId) {
                $query->where('school_id', $schoolId);
            })
            ->latest()
            ->paginate(15);

        // Charger les écoles pour le filtre (uniquement pour Super Admin)
        $schools = [];
        if ($user->role->name === 'Super Administrateur') {
            $schools = School::all();
        }

        return view('students.index', compact('students', 'schools'));
    }

    public function create()
    {
        $user = auth()->user();

        // Récupérer les utilisateurs avec le rôle "Élève" qui n'ont pas encore de profil étudiant
        $availableStudentUsers = User::whereHas('role', function ($query) {
            $query->where('name', 'Eleve');
        })
            ->whereDoesntHave('student')  // N'ont pas encore de profil étudiant
            ->when($user->role->name === 'Administrateur', function ($query) use ($user) {
                $query->where('school_id', $user->school_id);
            })
            ->select('id', 'name', 'first_name', 'email') // Sélectionner les champs nécessaires
            ->orderBy('name')
            ->get();

        // Vérifier si nous avons des élèves disponibles
        if ($availableStudentUsers->isEmpty()) {
            return redirect()->route('students.index')
                ->with('error', 'Aucun élève disponible pour créer un profil étudiant.');
        }

        // Récupérer les classes, options et promotions selon le rôle
        if ($user->role->name === 'Super Administrateur') {
            $classes = Classe::all();
            $options = Option::all();
            $promotions = Promotion::all();
        } else {
            $classes = Classe::where('school_id', $user->school_id)->get();
            $options = Option::where('school_id', $user->school_id)->get();
            $promotions = Promotion::where('school_id', $user->school_id)->get();
        }

        return view('students.form', compact(
            'availableStudentUsers',
            'classes',
            'options',
            'promotions'
        ));
    }

    public function edit(Student $student)
    {
        $user = auth()->user();

        if ($user->role->name === 'Super Administrateur') {
            $classes = Classe::all();
            $options = Option::all();
            $promotions = Promotion::all();
        } else {
            $classes = Classe::where('school_id', $user->school_id)->get();
            $options = Option::where('school_id', $user->school_id)->get();
            $promotions = Promotion::where('school_id', $user->school_id)->get();
        }

        return view('students.form', compact(
            'student',
            'classes',
            'options',
            'promotions'
        ));
    }

    public function store(StudentRequest $request)
    {
        $student = $this->studentService->createStudent($request->validated());

        return redirect()
            ->route('students.index')
            ->with('success', 'Élève ajouté avec succès');
    }

    public function update(StudentRequest $request, Student $student)
    {
        $this->studentService->updateStudent($student, $request->validated());

        return redirect()
            ->route('students.index')
            ->with('success', 'Élève modifié avec succès');
    }

    public function history(Student $student)
    {
        $this->authorize('view', $student);

        $histories = $student->histories()
            ->with(['school', 'class', 'option', 'promotion'])
            ->orderBy('start_date', 'desc')
            ->get();

        return view('students.history', compact('student', 'histories'));
    }

    public function destroy(Student $student)
    {
        $this->authorize('delete', $student);

        try {
            // Supprimer d'abord l'historique
            $student->histories()->delete();

            // Puis supprimer l'étudiant
            $student->delete();

            return redirect()
                ->route('students.index')
                ->with('success', 'Élève supprimé avec succès');
        } catch (\Exception $e) {
            return redirect()
                ->route('students.index')
                ->with('error', 'Une erreur est survenue lors de la suppression');
        }
    }

    public function show(Student $student)
    {
        $this->authorize('view', $student);

        // Charger les relations nécessaires
        $student->load([
            'user',
            'school',
            'class',
            'option',
            'promotion',
            'histories' => function ($query) {
                $query->with(['school', 'class', 'option', 'promotion'])
                    ->orderBy('start_date', 'desc');
            }
        ]);

        return view('students.show', compact('student'));
    }
}
