<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use App\Models\Student;
use App\Models\Classe;
use App\Models\StudentHistory;
use App\Services\PromotionService;
use Illuminate\Http\Request;

class StudentPromotionController extends Controller
{
    protected $promotionService;

    public function __construct(PromotionService $promotionService)
    {
        $this->promotionService = $promotionService;
    }

    public function index()
    {
        $this->authorize('viewAny', Student::class);
        $this->authorize('viewAny', Promotion::class);

        $students = Student::with(['user', 'class', 'histories' => function($query) {
                $query->where('status', 'active');
            }])
            ->when(auth()->user()->role->name !== 'Super Administrateur', function($query) {
                return $query->where('school_id', auth()->user()->school_id);
            })
            ->get();

        $classes = Classe::when(auth()->user()->role->name !== 'Super Administrateur', function($query) {
                return $query->where('school_id', auth()->user()->school_id);
            })
            ->orderBy('level')
            ->get();

        return view('students.promotions.index', compact('students', 'classes'));
    }

    public function create()
    {
        $this->authorize('create', StudentHistory::class);
        $this->authorize('promoteStudents', Promotion::class);

        $students = Student::with(['user', 'class', 'histories' => function($query) {
            $query->where('status', 'active');
        }])
            ->when(auth()->user()->role->name !== 'Super Administrateur', function($query) {
                return $query->where('school_id', auth()->user()->school_id);
            })
            ->get();

        $classes = Classe::when(auth()->user()->role->name !== 'Super Administrateur', function($query) {
            return $query->where('school_id', auth()->user()->school_id);
        })
            ->orderBy('name') // Temporairement, on trie par nom au lieu du level
            ->get();

        return view('students-stories.form', compact('students', 'classes'));
    }

    public function promote(Request $request)
    {
        $this->authorize('promote', Student::class);
        $this->authorize('promoteStudents', Promotion::class);

        $request->validate([
            'students' => 'required|array',
            'students.*' => 'exists:students,id',
            'target_class_id' => 'required|exists:classes,id',
            'academic_year' => 'required|string',
            'promotion_type' => 'required|in:automatic,manual'
        ]);

        $this->promotionService->promoteStudents(
            $request->students,
            $request->target_class_id,
            $request->academic_year,
            $request->promotion_type
        );

        return redirect()
            ->route('student-promotions.index')
            ->with('success', 'Élèves promus avec succès');
    }
}
