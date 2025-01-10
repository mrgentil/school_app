@extends('layouts.main')
@section('title', isset($question) ? 'Modifier une question' : 'Ajouter une question')

@section('content')
    <div class="dashboard-content-one">
        <div class="breadcrumbs-area">
            <h3>Gestion des Questions</h3>
            <ul>
                <li>
                    <a href="{{ url('/') }}">Accueil</a>
                </li>
                <li>{{ isset($question) ? 'Modifier' : 'Nouvelle' }} Question</li>
            </ul>
        </div>

        <div class="card height-auto">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>{{ isset($question) ? 'Modifier' : 'Ajouter' }} une Question</h3>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ isset($question) ? route('questions.update', $question) : route('questions.store') }}" method="POST" class="new-added-form">
                    @csrf
                    @if (isset($question))
                        @method('PUT')
                    @endif

                    <div class="row">
                        <!-- Question -->
                        <div class="col-xl-6 col-lg-6 col-12 form-group">
                            <label for="question">Question *</label>
                            <textarea name="question" id="question" class="form-control" rows="4" required>{{ old('question', $question->question ?? '') }}</textarea>
                        </div>

                        <!-- School -->
                        @if(Auth::user()->isSuperAdmin())
                            <div class="col-xl-6 col-lg-6 col-12 form-group">
                                <label for="school_id">Ecole *</label>
                                <select name="school_id" id="school_id" class="select2 form-control" required>
                                    @foreach($schools as $school)
                                        <option value="{{ $school->id }}" {{ old('school_id', $question->school_id ?? '') == $school->id ? 'selected' : '' }}>
                                            {{ $school->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <input type="hidden" name="school_id" value="{{ Auth::user()->school_id }}">
                        @endif

                        <!-- Type -->
                        <div class="col-xl-6 col-lg-6 col-12 form-group">
                            <label for="type">Type *</label>
                            <select name="type" id="type" class="select2 form-control" required>
                                <option value="Multiple Choice" {{ old('type', $question->type ?? '') == 'Multiple Choice' ? 'selected' : '' }}>Choix Multiple</option>
                                <option value="Essay" {{ old('type', $question->type ?? '') == 'Essay' ? 'selected' : '' }}>Rédaction</option>
                            </select>
                        </div>

                        <!-- Options -->
                        <div class="col-xl-6 col-lg-6 col-12 form-group">
                            <label for="options">Options (si applicable)</label>
                            <textarea name="options" id="options" class="form-control" rows="3">{{ old('options', $question->options ?? '') }}</textarea>
                        </div>

                        <!-- Correct Answer -->
                        <div class="col-xl-6 col-lg-6 col-12 form-group">
                            <label for="correct_answer">Réponse correcte *</label>
                            <input type="text" name="correct_answer" id="correct_answer" value="{{ old('correct_answer', $question->correct_answer ?? '') }}" class="form-control" required>
                        </div>

                        <!-- Exam -->
                        <div class="col-xl-6 col-lg-6 col-12 form-group">
                            <label for="exam_id">Examen *</label>
                            <select name="exam_id" id="exam_id" class="select2 form-control" required>
                                <option value="" disabled {{ old('exam_id', $question->exam_id ?? '') == null ? 'selected' : '' }}>Sélectionner un examen</option>
                                @foreach ($exams as $exam)
                                    <option value="{{ $exam->id }}" {{ old('exam_id', $question->exam_id ?? '') == $exam->id ? 'selected' : '' }}>
                                        {{ $exam->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Subject -->
                        <div class="col-xl-6 col-lg-6 col-12 form-group">
                            <label for="subject_id">Matière *</label>
                            <select name="subject_id" id="subject_id" class="select2 form-control" required>
                                <option value="" disabled {{ old('subject_id', $question->subject_id ?? '') == null ? 'selected' : '' }}>Sélectionner une matière</option>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ old('subject_id', $question->subject_id ?? '') == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Active Status -->
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label for="is_active">Activer *</label>
                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $question->is_active ?? false) ? 'checked' : '' }}>
                        </div>

                        <!-- Submit -->
                        <div class="col-12 form-group mg-t-8">
                            <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">
                                {{ isset($question) ? 'Modifier' : 'Ajouter' }}
                            </button>
                            <button type="reset" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Réinitialiser</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
