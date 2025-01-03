<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Http\Requests\SchoolRequest;
use App\Services\SchoolService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SchoolController extends Controller
{
    protected $schoolService;

    public function __construct(SchoolService $schoolService)
    {
        $this->schoolService = $schoolService;
        $this->middleware('auth');
        $this->authorizeResource(School::class, 'school');
    }

    public function index()
    {
        $currentUser = auth()->user();
        $schools = $this->schoolService->getSchoolsList($currentUser, [
            'name' => request('name')
        ]);

        return view('schools.index', compact('schools'));
    }

    public function create()
    {
        return view('schools.form');
    }

    public function store(SchoolRequest $request)
    {
        try {
            $school = $this->schoolService->createSchool($request->validated());
            return redirect()
                ->route('schools.index')
                ->with('success', 'École créée avec succès.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors('Une erreur est survenue lors de la création de l\'école.');
        }
    }

    public function edit(School $school)
    {
        return view('schools.form', compact('school'));
    }

    public function update(SchoolRequest $request, School $school)
    {
        try {
            $this->schoolService->updateSchool($school, $request->validated());
            return redirect()
                ->route('schools.index')
                ->with('success', 'École modifiée avec succès.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors('Une erreur est survenue lors de la modification de l\'école.');
        }
    }

    public function destroy(School $school)
    {
        try {
            $this->schoolService->deleteSchool($school);
            return redirect()
                ->route('schools.index')
                ->with('success', 'École supprimée avec succès.');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function search(Request $request)
    {
        try {
            $schools = $this->schoolService->searchSchools(
                $request->only(['name', 'address']),
                auth()->user()
            );

            if ($request->ajax()) {
                return response()->json([
                    'schools' => $schools,
                    'html' => view('schools.partials.schools-table', compact('schools'))->render()
                ]);
            }
            return view('schools.index', compact('schools'));
        } catch (\Exception $e) {
            Log::error('Erreur recherche écoles: ' . $e->getMessage());
            return $request->ajax()
                ? response()->json(['error' => 'Une erreur est survenue.'], 500)
                : back()->withErrors('Une erreur est survenue lors de la recherche.');
        }
    }
}
