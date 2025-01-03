<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Teacher;
use App\Models\School;
use App\Models\Subject;
use App\Http\Requests\TeacherRequest;
use App\Models\User;
use App\Services\TeacherService;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    protected $teacherService;

    public function __construct(TeacherService $teacherService)
    {
        $this->teacherService = $teacherService;
    }

    public function index()
    {
        $this->authorize('viewAny', Teacher::class);

        $teachers = Teacher::when(auth()->user()->role->name !== 'Super Administrateur', function ($query) {
            return $query->where('school_id', auth()->user()->school_id);
        })->with(['user', 'school', 'subjects'])->latest()->paginate(15);

        return view('teachers.index', compact('teachers'));
    }

    public function create()
    {
        $this->authorize('create', Teacher::class);

        // Récupère les utilisateurs qui ont le rôle de professeur et qui ne sont pas déjà assignés comme professeur
        $users = User::whereHas('role', function ($query) {
            $query->where('name', 'Professeur');
        })->whereDoesntHave('teacher')
            ->when(auth()->user()->role->name !== 'Super Administrateur', function ($query) {
                return $query->where('school_id', auth()->user()->school_id);
            })
            ->get();

        $schools = auth()->user()->role->name === 'Super Administrateur'
            ? School::all()
            : School::where('id', auth()->user()->school_id)->get();

        return view('teachers.form', compact('users', 'schools'));
    }

    public function store(TeacherRequest $request)
    {
        $this->authorize('create', Teacher::class);

        $teacher = $this->teacherService->create($request->validated());

        return redirect()->route('teachers.index')
            ->with('success', 'Professeur ajouté avec succès');
    }

    public function show(Teacher $teacher)
    {
        $this->authorize('view', $teacher);

        $teacher->load(['user', 'school', 'subjects.classes']);

        return view('teachers.show', compact('teacher'));
    }

    public function edit(Teacher $teacher)
    {
        $this->authorize('update', $teacher);

        // Pour l'édition, inclure l'utilisateur actuel du professeur plus les utilisateurs disponibles
        $users = User::whereHas('role', function ($query) {
            $query->where('name', 'Professeur');
        })->where(function ($query) use ($teacher) {
            $query->whereDoesntHave('teacher')
                ->orWhere('id', $teacher->user_id);
        })
            ->when(auth()->user()->role->name !== 'Super Administrateur', function ($query) {
                return $query->where('school_id', auth()->user()->school_id);
            })
            ->get();

        $schools = auth()->user()->role->name === 'Super Administrateur'
            ? School::all()
            : School::where('id', auth()->user()->school_id)->get();

        return view('teachers.form', compact('teacher', 'users', 'schools'));
    }

    public function update(TeacherRequest $request, Teacher $teacher)
    {
        $this->authorize('update', $teacher);

        $this->teacherService->update($teacher, $request->validated());

        return redirect()->route('teachers.index')
            ->with('success', 'Professeur modifié avec succès');
    }

    public function destroy(Teacher $teacher)
    {
        $this->authorize('delete', $teacher);

        $this->teacherService->delete($teacher);

        return redirect()->route('teachers.index')
            ->with('success', 'Professeur supprimé avec succès');
    }

    public function assignSubjectsForm()
    {
        $this->authorize('create', Teacher::class);

        // Récupérer tous les utilisateurs avec le rôle Professeur
        $users = User::whereHas('role', function ($query) {
            $query->where('name', 'Professeur');
        })
            ->when(auth()->user()->role->name !== 'Super Administrateur', function ($query) {
                return $query->where('school_id', auth()->user()->school_id);
            })
            ->get();

        // Pour chaque utilisateur qui n'a pas d'enregistrement dans teachers, en créer un
        foreach ($users as $user) {
            Teacher::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'school_id' => $user->school_id,
                    'status' => 'active'
                ]
            );
        }

        // Récupérer les professeurs
        $teachers = Teacher::whereHas('user.role', function ($query) {
            $query->where('name', 'Professeur');
        })
            ->when(auth()->user()->role->name !== 'Super Administrateur', function ($query) {
                return $query->where('school_id', auth()->user()->school_id);
            })
            ->with('user')
            ->get();

        // Récupérer les matières selon le rôle
        $subjects = Subject::when(auth()->user()->role->name !== 'Super Administrateur', function ($query) {
            return $query->where('school_id', auth()->user()->school_id);
        })->get();

        // Récupérer les classes selon le rôle
        $classes = Classe::when(auth()->user()->role->name !== 'Super Administrateur', function ($query) {
            return $query->where('school_id', auth()->user()->school_id);
        })->get();

        return view('teachers.assign_subjects', compact('teachers', 'subjects', 'classes'));
    }

    public function assignSubjects(Request $request)
    {
        $this->authorize('create', Teacher::class);

        $validated = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'subjects' => 'required|array',
            'subjects.*' => 'exists:subjects,id',
            'classes' => 'required|array',
            'classes.*' => 'exists:classes,id',
            'academic_year' => 'required|string'
        ]);

        $teacher = Teacher::findOrFail($validated['teacher_id']);

        // Vérification de sécurité
        if (auth()->user()->role->name !== 'Super Administrateur' &&
            auth()->user()->school_id !== $teacher->school_id) {
            abort(403);
        }

        foreach ($validated['subjects'] as $subjectId) {
            foreach ($validated['classes'] as $classId) {
                $teacher->subjects()->attach($subjectId, [
                    'class_id' => $classId,  // Utiliser class_id
                    'school_id' => $teacher->school_id,
                    'academic_year' => $validated['academic_year']
                ]);
            }
        }

        return redirect()->back()->with('success', 'Matières assignées avec succès');
    }

    public function schedule(Teacher $teacher)
    {
        $this->authorize('view', $teacher);

        $schedule = $teacher->subjects()
            ->with(['classes'])
            ->wherePivot('academic_year', getCurrentAcademicYear())
            ->get()
            ->groupBy('pivot.class_id');

        return view('teachers.schedule', compact('teacher', 'schedule'));
    }

    public function export()
    {
        $this->authorize('viewAny', Teacher::class);

        $teachers = Teacher::when(auth()->user()->role->name !== 'Super Administrateur', function ($query) {
            return $query->where('school_id', auth()->user()->school_id);
        })->with(['user', 'school', 'subjects'])->get();

        return response()->json([
            'data' => $teachers,
            'timestamp' => now(),
            'exported_by' => auth()->user()->name
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        $teacherId = $request->get('teacher_id');

        $subjects = Subject::when($query, function ($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%")
                ->orWhere('code', 'LIKE', "%{$query}%");
        })
            ->when($teacherId, function ($q) use ($teacherId) {
                $q->whereHas('teachers', function ($q) use ($teacherId) {
                    $q->where('teacher_id', $teacherId);
                });
            })
            ->with(['school'])
            ->limit(10)
            ->get();

        return response()->json($subjects);
    }

    public function assignedTeachers()
{
    $this->authorize('viewAny', Teacher::class);

    $teachers = Teacher::whereHas('subjects')
        ->when(auth()->user()->role->name !== 'Super Administrateur', function($query) {
            return $query->where('school_id', auth()->user()->school_id);
        })
        ->with(['user', 'school', 'subjects' => function($query) {
            $query->withPivot(['class_id', 'academic_year']);
        }])
        ->get()
        ->map(function($teacher) {
            // Organiser les données par année académique
            $assignments = collect();

            foreach($teacher->subjects as $subject) {
                $year = $subject->pivot->academic_year;
                if (!$assignments->has($year)) {
                    $assignments[$year] = collect();
                }

                $assignments[$year]->push([
                    'subject' => $subject,
                    'class_id' => $subject->pivot->class_id,
                    'academic_year' => $year
                ]);
            }

            $teacher->assignments = $assignments;
            return $teacher;
        });

    return view('teachers.assigned_list', compact('teachers'));
}

    public function removeSubject(Teacher $teacher, Subject $subject, Request $request)
    {
        $this->authorize('update', $teacher);

        $teacher->subjects()->wherePivot('subject_id', $subject->id)
            ->wherePivot('class_id', $request->class)
            ->wherePivot('academic_year', $request->academic_year)
            ->detach();

        return redirect()->back()->with('success', 'Assignation supprimée avec succès');
    }

    public function assigned_list(Request $request)
    {
        $search = $request->input('search');
        $teacher_id = $request->input('teacher_id');

        $teachers = Teacher::when($search, function ($query) use ($search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('first_name', 'LIKE', "%{$search}%")
                    ->orWhere('last_name', 'LIKE', "%{$search}%");
            });
        })
            ->when($teacher_id, function ($query) use ($teacher_id) {
                $query->where('id', $teacher_id);
            })
            ->with(['user', 'school', 'subjects'])
            ->paginate(15);

        return view('teachers.assigned_list', compact('teachers'));
    }
}
