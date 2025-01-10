<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Question;
use App\Models\School;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'Super Administrateur') {
            // Super Administrateur peut voir toutes les questions
            $questions = Question::all();
        } else {
            // Administrateur : Voir les questions créées par les utilisateurs de son école
            $questions = Question::whereHas('exam.creator', function ($query) use ($user) {
                $query->where('school_id', $user->school_id);
            })->get();
        }

        return view('questions.index', compact('questions'));
    }




    public function create()
    {
        $user = Auth::user();

        if (!$user->isSuperAdmin() && !$user->isAdmin()) {
            return redirect()->route('questions.index')->with('error', 'Unauthorized action.');
        }

        $exams = Exam::all(); // Récupérer tous les examens
        $subjects = Subject::all(); // Récupérer toutes les matières
        // Transmettre les écoles uniquement pour les Super Administrateurs
        $schools = $user->isSuperAdmin() ? School::all() : null;

        return view('questions.form', compact('exams', 'subjects','schools'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'question' => 'required|string',
            'type' => 'required|string',
            'options' => 'nullable|json',
            'correct_answer' => 'nullable|string',
            'exam_id' => 'nullable|exists:exams,id',
            'subject_id' => 'nullable|exists:subjects,id',
        ]);

        Question::create([
            'question' => $request->question,
            'type' => $request->type,
            'options' => $request->options,
            'correct_answer' => $request->correct_answer,
            'is_active' => $request->has('is_active'),
            'exam_id' => $request->exam_id,
            'subject_id' => $request->subject_id,
            'created_by' => $user->id,
        ]);

        return redirect()->route('questions.index')->with('success', 'Question créée avec succès.');
    }

    public function edit(Question $question)
    {
        $user = Auth::user();

        if (!$user->isSuperAdmin() && $exam->school_id !== $user->school_id) {
            return redirect()->route('exams.index')->with('error', 'Unauthorized action.');
        }

        $this->authorize('update', $question);

        $exams = Exam::all();
        $subjects = Subject::all();

        $schools = $user->isSuperAdmin() ? School::all() : null;
        return view('questions.form', compact('question', 'exams', 'subjects','schools'));
    }

    public function update(Request $request, Question $question)
    {
        $this->authorize('update', $question);

        $request->validate([
            'question' => 'required|string',
            'type' => 'required|string',
            'options' => 'nullable|json',
            'correct_answer' => 'nullable|string',
            'exam_id' => 'nullable|exists:exams,id',
            'subject_id' => 'nullable|exists:subjects,id',
        ]);

        $question->update($request->all());

        return redirect()->route('questions.index')->with('success', 'Question mise à jour avec succès.');
    }

    public function destroy(Question $question)
    {
        $this->authorize('delete', $question);

        $question->delete();

        return redirect()->route('questions.index')->with('success', 'Question supprimée avec succès.');
    }
}
