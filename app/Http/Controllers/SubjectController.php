<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Subject;
use App\Models\School;
use App\Models\Teacher;
use App\Http\Requests\SubjectRequest;
use App\Services\SubjectService;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    protected $subjectService;

    public function __construct(SubjectService $subjectService)
    {
        $this->subjectService = $subjectService;
    }

    public function index()
    {
        $this->authorize('viewAny', Subject::class);

        $subjects = Subject::when(auth()->user()->role->name !== 'Super Administrateur', function ($query) {
            return $query->where('school_id', auth()->user()->school_id);
        })->with(['school', 'creator', 'teachers'])->latest()->paginate(15);

        return view('subjects.index', compact('subjects'));
    }

    public function create()
    {
        $this->authorize('create', Subject::class);

        $classes = Classe::when(auth()->user()->role->name !== 'Super Administrateur', function($query) {
            return $query->where('school_id', auth()->user()->school_id);
        })->get();

        $schools = auth()->user()->role->name === 'Super Administrateur'
            ? School::all()
            : School::where('id', auth()->user()->school_id)->get();

        return view('subjects.form', compact('classes', 'schools'));
    }

    public function store(SubjectRequest $request)
    {
        $this->authorize('create', Subject::class);

        $data = $request->validated();

        if (auth()->user()->role->name !== 'Super Administrateur') {
            $data['school_id'] = auth()->user()->school_id;
        }

        $data['created_by'] = auth()->id();

        // Extraire les IDs des classes
        $classIds = $data['class_ids'];
        unset($data['class_ids']);

        // Créer la matière
        $subject = Subject::create($data);

        // Attacher les classes
        $subject->classes()->attach($classIds);

        return redirect()->route('subjects.index')
            ->with('success', 'Matière ajoutée avec succès');
    }

    public function show(Subject $subject)
    {
        $this->authorize('view', $subject);

        $subject->load(['school', 'creator', 'teachers.user', 'teachers.classes']);

        return view('subjects.show', compact('subject'));
    }

    public function edit(Subject $subject)
    {
        $this->authorize('update', $subject);

        $schools = auth()->user()->role->name === 'Super Administrateur'
            ? School::all()
            : School::where('id', auth()->user()->school_id)->get();

        return view('subjects.form', compact('subject', 'schools'));
    }

    public function update(SubjectRequest $request, Subject $subject)
    {
        $this->authorize('update', $subject);

        $data = $request->validated();

        // Extraire les IDs des classes
        $classIds = $data['class_ids'];
        unset($data['class_ids']);

        // Mettre à jour la matière
        $subject->update($data);

        // Synchroniser les classes
        $subject->classes()->sync($classIds);

        return redirect()->route('subjects.index')
            ->with('success', 'Matière mise à jour avec succès');
    }

    public function destroy(Subject $subject)
    {
        $this->authorize('delete', $subject);

        $this->subjectService->delete($subject);

        return redirect()->route('subjects.index')
            ->with('success', 'Matière supprimée avec succès');
    }

    public function assignTeachers(Request $request, Subject $subject)
    {
        $this->authorize('update', $subject);

        $validated = $request->validate([
            'teachers' => 'required|array',
            'teachers.*.teacher_id' => 'required|exists:teachers,id',
            'teachers.*.class_id' => 'required|exists:classes,id',
            'academic_year' => 'required|string',
        ]);

        $this->subjectService->assignTeachers($subject, $validated);

        return redirect()->route('subjects.show', $subject)
            ->with('success', 'Enseignants assignés avec succès');
    }

    public function duplicate(Subject $subject)
    {
        $this->authorize('create', Subject::class);

        try {
            $newSubject = $this->subjectService->duplicate($subject);

            return redirect()->route('subjects.edit', $newSubject)
                ->with('success', 'Matière dupliquée avec succès');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la duplication de la matière');
        }
    }

    public function search(Request $request)
    {
        $this->authorize('viewAny', Subject::class);

        $query = $request->get('q');

        $subjects = Subject::when(auth()->user()->role->name !== 'Super Administrateur', function ($q) {
            return $q->where('school_id', auth()->user()->school_id);
        })
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                    ->orWhere('code', 'LIKE', "%{$query}%");
            })
            ->with(['school'])
            ->limit(10)
            ->get();

        return response()->json($subjects);
    }

    public function export()
    {
        $this->authorize('viewAny', Subject::class);

        $subjects = Subject::when(auth()->user()->role->name !== 'Super Administrateur', function ($query) {
            return $query->where('school_id', auth()->user()->school_id);
        })->with(['school', 'creator', 'teachers.user'])->get();

        return response()->json([
            'data' => $subjects,
            'timestamp' => now(),
            'exported_by' => auth()->user()->name
        ]);
    }

    public function getTeachersBySubject(Subject $subject)
    {
        $this->authorize('view', $subject);

        $teachers = $subject->teachers()
            ->with(['user', 'classes'])
            ->get()
            ->groupBy('pivot.academic_year');

        return response()->json($teachers);
    }
}
