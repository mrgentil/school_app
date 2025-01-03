@extends('layouts.main')

@section('title', 'Details Matière ' . $subject->name)

@section('content')
    <div class="dashboard-content-one">
        <div class="breadcrumbs-area">
            <h3>Details Matière</h3>
            <ul>
                <li><a href="{{ url('/') }}">Accueil</a></li>
                <li>Details Matière</li>
            </ul>
        </div>

        <div class="card height-auto">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>Details Matière {{ $subject->name }}</h3>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4>Informations de la matière</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <p>Code : {{ $subject->code }}</p>
                        <p>Description : {{ $subject->description }}</p>
                        <p>École : {{ $subject->school->name }}</p>
                        <p>Créé par : {{ $subject->creator->name }}</p>
                    </div>
                </div>

                @if($subject->teachers->count() > 0)
                    <div class="card mt-4">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4>Enseignants assignés</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            @foreach($subject->teachers as $teacher)
                                <div class="mb-4">
                                    <h5 class="text-primary">{{ $teacher->user->name }} {{ $teacher->user->first_name }}</h5>
                                    <p>École : {{ $teacher->school->name }}</p>
                                    <p>Spécialité : {{ $teacher->speciality }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="alert alert-info mt-4">
                        Aucun enseignant n'a encore été assigné à cette matière.
                    </div>
                @endif

                @if($subject->classes->count() > 0)
                    <div class="card mt-4">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4>Classes assignées</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            @foreach($subject->classes as $class)
                                <div class="mb-4">
                                    <h5 class="text-primary">{{ $class->name }}</h5>
                                    <p>Niveau : {{ $class->level }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="alert alert-info mt-4">
                        Aucune classe n'a encore été assignée à cette matière.
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
