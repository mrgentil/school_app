<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScheduleRequest;
use App\Models\Classe;
use App\Models\Schedule;
use App\Models\School;
use App\Models\Subject;
use App\Models\User;
use App\Services\ScheduleService;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    protected $scheduleService;

    public function __construct(ScheduleService $scheduleService)
    {
        $this->scheduleService = $scheduleService;

        // Autorise les actions via la Policy
        $this->authorizeResource(Schedule::class, 'schedule');
    }

    /**
     * Affiche la liste des horaires.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Dans votre contrôleur
        $schedules = Schedule::with(['teacher' => function ($query) {
            $query->whereHas('role', function ($roleQuery) {
                $roleQuery->where('name', 'Professeur');
            });
        }])->get();

        //dd($schedules);
        return view('schedules.index', compact('schedules'));
    }

    /**
     * Affiche le formulaire de création d'un horaire.
     *
     * @return \Illuminate\View\View|\Symfony\Component\HttpFoundation\Response
     */
    public function create()
    {
        $user = auth()->user();
        $data = $this->fetchFormDependencies($user);

        return view('schedules.form', $data);
    }

    /**
     * Enregistre un nouvel horaire.
     *
     * @param ScheduleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ScheduleRequest $request)
    {
        $this->scheduleService->createSchedule($request->validated());
        return redirect()->route('schedules.index')->with('success', 'Horaire créé avec succès.');
    }

    /**
     * Affiche le formulaire d'édition d'un horaire.
     *
     * @param Schedule $schedule
     * @return \Illuminate\View\View|\Symfony\Component\HttpFoundation\Response
     */
    public function edit(Schedule $schedule)
    {
        $user = auth()->user();
        $data = $this->fetchFormDependencies($user);
        $data['schedule'] = $schedule;

        return view('schedules.form', $data);
    }

    /**
     * Met à jour un horaire existant.
     *
     * @param ScheduleRequest $request
     * @param Schedule $schedule
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ScheduleRequest $request, Schedule $schedule)
    {
        $this->scheduleService->updateSchedule($schedule, $request->validated());
        return redirect()->route('schedules.index')->with('success', 'Horaire mis à jour avec succès.');
    }

    /**
     * Supprime un horaire.
     *
     * @param Schedule $schedule
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Schedule $schedule)
    {
        $this->scheduleService->deleteSchedule($schedule);
        return redirect()->route('schedules.index')->with('success', 'Horaire supprimé avec succès.');
    }

    /**
     * Récupère les dépendances nécessaires pour les formulaires.
     *
     * @param \App\Models\User $user L'utilisateur connecté.
     * @return array Les données nécessaires pour les formulaires.
     */
    private function fetchFormDependencies($user): array
    {
        if ($user->role->name === 'Super Administrateur') {
            // Le Super Administrateur voit toutes les données
            $teachers = User::professors()->get();
            $classes = Classe::all();
            $subjects = Subject::all();
            $schools = School::all();
        } elseif ($user->role->name === 'Administrateur') {
            // L'Administrateur voit uniquement les données de son école
            $teachers = User::professors()->where('school_id', $user->school_id)->get();
            $classes = Classe::where('school_id', $user->school_id)->get();
            $subjects = Subject::where('school_id', $user->school_id)->get();
            $schools = null; // Pas nécessaire pour l'administrateur
        } else {
            abort(403, 'Action non autorisée.');
        }

        return compact('teachers', 'classes', 'subjects', 'schools');
    }
}
