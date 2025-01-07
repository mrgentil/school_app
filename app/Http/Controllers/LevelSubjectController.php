<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\School;
use App\Models\Subject;
use Illuminate\Http\Request;

class LevelSubjectController extends Controller
{
    public function index()
    {
        $levels = Level::all();
        return view('levels.index', compact('levels'));
    }

    public function showSubjectsByLevel($levelId)
    {
        $level = Level::with('subjects')->findOrFail($levelId);
        $subjects = Subject::all();
        $schools = School::all();
        return view('levels.subjects', compact('level', 'subjects', 'schools'));
    }


    public function assignSubjectToLevel(Request $request, $levelId)
    {
        $level = Level::findOrFail($levelId);
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'school_id' => 'required|exists:schools,id',
            'hours_per_week' => 'required|integer|min:0',
        ]);

        $level->subjects()->attach($validated['subject_id'], [
            'school_id' => $validated['school_id'],
            'hours_per_week' => $validated['hours_per_week'],
        ]);

        return redirect()->route('levels.subjects.show', $levelId)
            ->with('success', 'Matière assignée au niveau avec succès');
    }

    public function getSubjectsByLevel($levelId)
    {
        $level = Level::with('subjects')->findOrFail($levelId);
        return response()->json($level->subjects);
    }

}
