@extends('layouts.main')
@section('title', "Détails de l'examen")

@section('content')
    <div class="dashboard-content-one">
        <div class="breadcrumbs-area">
            <h3>Détails de l'examen</h3>
            <ul>
                <li><a href="{{ url('/') }}">Accueil</a></li>
                <li><a href="{{ route('exams.index') }}">Examens</a></li>
                <li>Détails</li>
            </ul>
        </div>

        <div class="card height-auto">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>Informations de l'examen</h3>
                    </div>
                    <div class="dropdown">
                        @can('update', $exam)
                            <a href="{{ route('exams.edit', $exam) }}"
                               class="btn-fill-md btn-gradient-yellow btn-hover-bluedark">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                        @endcan
                    </div>
                </div>

                <!-- Informations de l'examen -->
                <div class="single-info-details">
                    <div class="item-content">
                        <div class="header-inline mb-4">
                            <h3 class="text-dark-medium font-medium">Informations principales</h3>
                        </div>
                        <div class="info-table table-responsive">
                            <table class="table text-nowrap">
                                <tbody>
                                <tr>
                                    <td>Titre:</td>
                                    <td>{{ $exam->title }}</td>
                                </tr>
                                <tr>
                                    <td>Date de l'examen:</td>
                                    <td>{{ \Carbon\Carbon::parse($exam->exam_date)->translatedFormat('l, d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td>Durée:</td>
                                    <td>{{ $exam->duration }} minutes</td>
                                </tr>
                                <tr>
                                    <td>Type:</td>
                                    <td>{{ $exam->examType->name }}</td>
                                </tr>
                                <tr>
                                    <td>Classe:</td>
                                    <td>{{ $exam->class->name }}</td>
                                </tr>
                                <tr>
                                    <td>Matière:</td>
                                    <td>{{ $exam->subject->name }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Questions -->
                <div class="single-info-details mt-4">
                    <div class="item-content">
                        <div class="header-inline mb-4">
                            <h3 class="text-dark-medium font-medium">Questions</h3>
                        </div>
                        @if ($exam->questions->isEmpty())
                            <p>Aucune question disponible pour cet examen.</p>
                        @else
                            <div class="info-table table-responsive">
                                <table class="table text-nowrap">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Type</th>
                                        <th>Question</th>
                                        <th>Options</th>
                                        <th>Bonne réponse</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($exam->questions as $index => $question)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $question->type }}</td>
                                            <td>{{ $question->question }}</td>
                                            <td>{{ $question->type == 'Multiple Choice' ? $question->options : '-' }}</td>
                                            <td>{{ $question->correct_answer }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Dates -->


                <!-- Boutons d'action -->
                <div class="mt-4">
                    <a href="{{ route('exams.index') }}" class="btn-fill-lg bg-blue-dark btn-hover-yellow">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>

                    @can('delete', $exam)
                        <form action="{{ route('exams.destroy', $exam) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet examen ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-fill-lg bg-gradient-gplus btn-hover-yellow">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection
