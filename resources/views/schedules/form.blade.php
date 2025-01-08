@extends('layouts.main')
@section('title', isset($schedule) ? 'Modifier un horaire' : 'Ajouter un horaire')

@section('meta_description')
    {{ isset($schedule) ? "Modification des informations de l'horaire {$schedule->name}" : "Formulaire d'ajout d'un nouvel horaire" }}
@endsection
@section('content')
    <div class="dashboard-content-one">
        <!-- Breadcubs Area Start Here -->
        <div class="breadcrumbs-area">
            <h3>Horaire des cours</h3>
            <ul>
                <li>
                    <a href="{{url('/')}}">Accueil</a>
                </li>
                <li>{{ isset($schedule) ? 'Modifier' : 'Nouveau' }} Horaires</li>
            </ul>
        </div>
        <!-- Breadcubs Area End Here -->
        <!-- Add New Teacher Area Start Here -->
        <div class="card height-auto">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>{{ isset($schedule) ? 'Modifier' : 'Ajouter' }} Horaire des cours</h3>
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

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST"
                      action="{{ isset($schedule) ? route('schedules.update', $user) : route('schedules.store') }}"
                      enctype="multipart/form-data" class="new-added-form">
                    @csrf
                    @if(isset($schedule))
                        @method('PUT')
                    @endif
                    <div class="row">
                        @if (auth()->user()->role->name === 'Super Administrateur')
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label for="school_id">École *</label>
                                <select name="school_id" id="school_id" class="form-control select2" required>
                                    @foreach ($schools as $school)
                                        <option
                                            value="{{ $school->id }}"
                                            {{ isset($schedule) && $schedule->school_id == $school->id ? 'selected' : '' }}>
                                            {{ $school->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label for="class_id">Classe *</label>
                            <select name="class_id" id="class_id" class="form-control select2" required>
                                @foreach ($classes as $class)
                                    <option
                                        value="{{ $class->id }}"
                                        {{ isset($schedule) && $schedule->class_id == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label for="subject_id">Matière *</label>
                            <select name="subject_id" id="subject_id" class="form-control select2" required>
                                @foreach ($subjects as $subject)
                                    <option
                                        value="{{ $subject->id }}"
                                        {{ isset($schedule) && $schedule->subject_id == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label for="teacher_id">Professeur *</label>
                            <select name="teacher_id" id="teacher_id" class="form-control select2" required>
                                @foreach ($teachers as $teacher)
                                    <option
                                        value="{{ $teacher->id }}"
                                        {{ isset($schedule) && $schedule->teacher_id == $teacher->id ? 'selected' : '' }}>
                                        {{ $teacher->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label for="day_of_week">Jour *</label>
                            <input type="text" name="day_of_week" id="day_of_week" class="form-control"
                                   value="{{ $schedule->day_of_week ?? old('day_of_week') }}" placeholder="Ex : Lundi"
                                   required>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label for="start_time">Heure Début</label>
                            <input type="time" name="start_time" id="start_time" class="form-control"
                                   value="{{ $schedule->start_time ?? old('start_time') }}" required>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label for="end_time">Heure Fin</label>
                            <input type="time" name="end_time" id="end_time" class="form-control"
                                   value="{{ $schedule->end_time ?? old('end_time') }}" required>
                        </div>
                        <div class="col-12 form-group mg-t-8">
                            <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">
                                {{ isset($schedule) ? 'Modifier' : 'Ajouter' }}
                            </button>
                            <button type="reset" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
