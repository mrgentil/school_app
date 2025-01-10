<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CurriculumController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\LevelSubjectController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentHistoryController;
use App\Http\Controllers\StudentPromotionController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TeacherWorkloadController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Auth::routes(['register' => false]);
Auth::routes(['reset' => true]);
Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {

    //Home Route
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //User  ROutes
    Route::resource('users', UserController::class)->except(['show']);
    Route::get('/users/search', [UserController::class, 'search'])->name('users.search');


    //Role Routes
    Route::resource('roles', \App\Http\Controllers\RoleController::class);

    //School Routes
    Route::resource('schools', \App\Http\Controllers\SchoolController::class);
    Route::get('/schools/search', [SchoolController::class, 'search'])->name('schools.search');

    //Student Routes
    Route::resource('students', \App\Http\Controllers\StudentController::class);

    //Class Routes
    Route::resource('classes', \App\Http\Controllers\ClasseController::class);

    //Option Routes
    Route::resource('options', \App\Http\Controllers\OptionController::class);

    //Promotion Routes
    Route::resource('promotions', \App\Http\Controllers\PromotionController::class);

    // Routes pour l'historique
    Route::get('histories', [StudentHistoryController::class, 'index'])
        ->name('histories.index');
    Route::get('histories/create', [StudentHistoryController::class, 'create'])
        ->name('histories.create');
    Route::post('histories', [StudentHistoryController::class, 'store'])
        ->name('histories.store');
    Route::get('histories/{history}/edit', [StudentHistoryController::class, 'edit'])
        ->name('histories.edit');
    Route::put('histories/{history}', [StudentHistoryController::class, 'update'])
        ->name('histories.update');
    Route::delete('histories/{history}', [StudentHistoryController::class, 'destroy'])
        ->name('histories.destroy');
    Route::get('histories/{history}', [StudentHistoryController::class, 'show'])  // Ajout de la route show
    ->name('histories.show');

    // Routes pour la promotion des élèves
    Route::get('student-promotions', [StudentPromotionController::class, 'index'])
        ->name('student-promotions.index');
    Route::get('student-promotions/create', [StudentPromotionController::class, 'create'])
        ->name('student-promotions.create');
    Route::post('student-promotions/promote', [StudentPromotionController::class, 'promote'])
        ->name('student-promotions.promote');

    Route::resource('teachers', TeacherController::class);
    Route::get('teachers/{teacher}/assign-subjects', [TeacherController::class, 'assignSubjectsForm'])
        ->name('teachers.assign-subjects-form');
    Route::post('teachers/{teacher}/assign-subjects', [TeacherController::class, 'assignSubjects'])
        ->name('teachers.assign-subjects');

    // Routes des matières
    Route::resource('subjects', SubjectController::class);
    // Route supplémentaire pour la duplication
    Route::post('subjects/{subject}/duplicate', [SubjectController::class, 'duplicate'])
        ->name('subjects.duplicate');

    // Route pour le formulaire d'assignation de matières
    Route::get('assign-subjects', [TeacherController::class, 'assignSubjectsForm'])
        ->name('teachers.assign-form');

    Route::post('assign-subjects', [TeacherController::class, 'assignSubjects'])
        ->name('teachers.assign');

// Route pour la liste des professeurs assignés
    Route::get('assigned-teachers', [TeacherController::class, 'assignedTeachers'])
        ->name('teachers.assigned');

    Route::delete('teachers/{teacher}/subjects/{subject}/remove', [TeacherController::class, 'removeSubject'])
        ->name('teachers.remove-subject');


    Route::get('/workload-overview', [TeacherWorkloadController::class, 'workloadOverview'])
        ->name('workload.overview');
    Route::put('/workload/{teacher}', [TeacherWorkloadController::class, 'update'])->name('workload.update');

    Route::get('/levels/{levelId}/subjects', [LevelSubjectController::class, 'showSubjectsByLevel'])->name('levels.subjects.show');
    Route::post('/levels/{levelId}/subjects', [LevelSubjectController::class, 'assignSubjectToLevel'])->name('levels.subjects.assign');
    Route::get('/levels', [LevelSubjectController::class, 'index'])->name('levels.index');
    Route::get('levels/{levelId}/subjects', [LevelSubjectController::class, 'getSubjectsByLevel'])->name('levels.subjects.assign');

    //Routes Programmes Scolaire
    Route::resource('programmes', ProgramController::class);
    Route::get('programmes/{id}/download', [ProgramController::class, 'download'])->name('programs.download');

    //Routes Schedules
    Route::resource('schedules', ScheduleController::class);

    //Routes Exam
    Route::resource('exams', ExamController::class);
    //Routes Question
    Route::resource('questions', QuestionController::class);
    Route::get('questions/{question}/download', [QuestionController::class, 'download'])->name('questions.download');
    Route::get('questions/{question}/answer', [QuestionController::class, 'answerQuestion'])->name('questions.answer');
    Route::get('questions/{question}/answered', [QuestionController::class, 'answeredQuestions'])->name('questions.answered');


});

