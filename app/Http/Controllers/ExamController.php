<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamType;
use App\Models\Classe;
use App\Models\School;
use App\Models\Subject;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        if ($user->isSuperAdmin()) {
            // Si l'utilisateur est Super Administrateur, il peut voir tous les examens
            $exams = Exam::all();
        } else {
            // Si l'utilisateur est un Administrateur, il ne voit que les examens de son école
            $exams = Exam::whereHas('creator', function ($query) use ($user) {
                $query->where('school_id', $user->school_id);
            })->get();
        }

        return view('exams.index', compact('exams'));
    }


    public function create()
    {
        $user = Auth::user();

        if (!$user->isSuperAdmin() && !$user->isAdmin()) {
            return redirect()->route('exams.index')->with('error', 'Unauthorized action.');
        }

        $examTypes = ExamType::all();
        $classes = Classe::where('school_id', $user->school_id)->get();
        $subjects = Subject::where('school_id', $user->school_id)->get();
        // Transmettre les écoles uniquement pour les Super Administrateurs
        $schools = $user->isSuperAdmin() ? School::all() : null;

        return view('exams.form', compact('examTypes', 'classes', 'subjects','schools'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'exam_date' => 'required|date',
            'duration' => 'required|integer|min:1',
            'exam_type_id' => 'required|exists:exam_types,id',
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $validated['created_by'] = $user->id;
        if (!$user->isSuperAdmin()) {
            $validated['school_id'] = $user->school_id;
        }

        Exam::create($validated);

        return redirect()->route('exams.index')->with('success', 'Exam created successfully.');
    }

    public function edit(Exam $exam)
    {
        $user = Auth::user();

        if (!$user->isSuperAdmin() && $exam->school_id !== $user->school_id) {
            return redirect()->route('exams.index')->with('error', 'Unauthorized action.');
        }

        $examTypes = ExamType::all();
        $classes = Classe::where('school_id', $user->school_id)->get();
        $subjects = Subject::where('school_id', $user->school_id)->get();
        // Transmettre les écoles uniquement pour les Super Administrateurs
        $schools = $user->isSuperAdmin() ? School::all() : null;

        return view('exams.form', compact('exam', 'examTypes', 'classes', 'subjects','schools'));
    }

    public function update(Request $request, Exam $exam)
    {
        $user = Auth::user();

        if (!$user->isSuperAdmin() && $exam->school_id !== $user->school_id) {
            return redirect()->route('exams.index')->with('error', 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'exam_date' => 'required|date',
            'duration' => 'required|integer|min:1',
            'exam_type_id' => 'required|exists:exam_types,id',
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $exam->update($validated);

        return redirect()->route('exams.index')->with('success', 'Exam updated successfully.');
    }

    public function destroy(Exam $exam)
    {
        $user = Auth::user();

        if (!$user->isSuperAdmin() && $exam->school_id !== $user->school_id) {
            return redirect()->route('exams.index')->with('error', 'Unauthorized action.');
        }

        $exam->delete();

        return redirect()->route('exams.index')->with('success', 'Exam deleted successfully.');
    }

    public function questionBank()
    {
        $user = Auth::user();

        if ($user->isSuperAdmin()) {
            $questions = Question::all();
        } else {
            $questions = Question::where('created_by', $user->id)->get();
        }

        return view('questions.index', compact('questions'));
    }

    public function show($id)
    {
        // Récupérer l'examen et ses questions associées
        $exam = Exam::with('questions')->findOrFail($id);

        // Retourner la vue avec les données
        return view('exams.show', compact('exam'));
    }

}
