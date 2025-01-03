@extends('layouts.main')
@section('title', 'Liste des professeurs assignés')

@section('content')
    <div class="dashboard-content-one">
        <div class="breadcrumbs-area">
            <h3>Professeurs assignés</h3>
            <ul>
                <li><a href="{{ url('/') }}">Accueil</a></li>
                <li>Liste des professeurs assignés</li>
            </ul>
        </div>

        <div class="card height-auto">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>Liste des professeurs et leurs matières assignées</h3>
                    </div>
                    <div class="dropdown">
                        <a href="{{ route('teachers.assign-form') }}" class="btn-fill-md text-light bg-gradient-yellow">
                            <i class="fas fa-plus"></i> Assigner une matière
                        </a>
                    </div>
                </div>
                
                @if($teachers->count() > 0)
                    @foreach($teachers as $teacher)
                        <div class="card mt-4">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4>{{ $teacher->user->name }} {{ $teacher->user->first_name }}</h4>
                                    <span class="badge badge-info">{{ $teacher->school->name }}</span>
                                </div>
                            </div>
                            <div class="card-body">
                                @foreach($teacher->assignments as $academicYear => $assignments)
                                    <div class="mb-4">
                                        <h5 class="text-primary">Année académique : {{ $academicYear }}</h5>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Matière</th>
                                                        <th>Code</th>
                                                        <th>Classe</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($assignments as $assignment)
                                                        <tr>
                                                            <td>{{ $assignment['subject']->name }}</td>
                                                            <td>{{ $assignment['subject']->code }}</td>
                                                            <td>
                                                                @php
                                                                    $class = App\Models\Classe::find($assignment['class_id']);
                                                                @endphp
                                                                {{ $class ? $class->name : 'N/A' }}
                                                            </td>
                                                            <td>
                                                                <form action="{{ route('teachers.remove-subject', [
                                                                    'teacher' => $teacher->id,
                                                                    'subject' => $assignment['subject']->id,
                                                                    'class' => $assignment['class_id'],
                                                                    'academic_year' => $assignment['academic_year']
                                                                ]) }}"
                                                                    method="POST"
                                                                    style="display: inline-block;"
                                                                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette assignation ?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="alert alert-info mt-4">
                        Aucun professeur n'a encore été assigné à des matières.
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
