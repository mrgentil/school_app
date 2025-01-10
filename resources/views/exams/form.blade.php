@extends('layouts.main')
@section('title', isset($exam) ? 'Modifier un examen' : 'Ajouter un examen')

@section('meta_description')
    {{ isset($exam) ? "Modification des informations de l'examen {$exam->title}" : "Formulaire d'ajout d'un nouvel examen" }}
@endsection
@section('content')
    <div class="dashboard-content-one">
        <!-- Breadcubs Area Start Here -->
        <div class="breadcrumbs-area">
            <h3>Examen</h3>
            <ul>
                <li>
                    <a href="{{url('/')}}">Accueil</a>
                </li>
                <li>{{ isset($exam) ? 'Modifier' : 'Nouveau' }} Examen</li>
            </ul>
        </div>
        <!-- Breadcubs Area End Here -->
        <!-- Add New Teacher Area Start Here -->
        <div class="card height-auto">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>{{ isset($exam) ? 'Modifier' : 'Ajouter' }} Examen</h3>
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
                      action="{{ isset($exam) ? route('exams.update', $exam) : route('exams.store') }}"
                      enctype="multipart/form-data" class="new-added-form">
                    @csrf
                    @if(isset($exam))
                        @method('PUT')
                    @endif
                    <div class="row">
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Titre *</label>
                            <input type="text" name="title" value="{{ old('title', $exam->title ?? '') }}"
                                   class="form-control" required>
                        </div>
                        @if($schools)
                            <div class="col-xl-3 col-lg-6 col-12 form-group">
                                <label for="school_id">Ecole *</label>
                                <select id="school_id" name="school_id" class="select2 form-control" required>
                                    @foreach($schools as $school)
                                        <option
                                            value="{{ $school->id }}" {{ isset($exam) && $exam->school_id == $school->id ? 'selected' : '' }}>
                                            {{ $school->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <input type="hidden" name="school_id" value="{{ Auth::user()->school_id }}">
                        @endif
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label for="exam_date">Date de l'examen *</label>
                            <input type="date" name="exam_date" value="{{ old('exam_date', $exam->exam_date ?? '') }}"
                                   class="form-control" required>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label for="duration">Durée *</label>
                            <input type="number" name="duration"
                                   value="{{ old('duration', $exam->duration ?? '') }}" class="form-control"
                                   required>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label for="exam_type_id">Type Examen *</label>
                            <select class="select2 form-control" name="exam_type_id" required>
                                @foreach($examTypes as $type)
                                    <option
                                        value="{{ $type->id }}" {{ isset($exam) && $exam->exam_type_id == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label for="class_id">Classe *</label>
                            <select class="select2 form-control" name="class_id" required>
                                @foreach($classes as $class)
                                    <option
                                        value="{{ $class->id }}" {{ isset($exam) && $exam->class_id == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label for="subject_id">Matière *</label>
                            <select class="select2 form-control" name="subject_id" required>
                                @foreach($subjects as $subject)
                                    <option
                                        value="{{ $subject->id }}" {{ isset($exam) && $exam->subject_id == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 form-group mg-t-8">
                            <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">
                                {{ isset($exam) ? 'Modifier' : 'Ajouter' }}
                            </button>
                            <button type="reset" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
