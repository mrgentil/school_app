@extends('layouts.main')
@section('title', 'Liste des professeurs')

@section('content')
<div class="dashboard-content-one">
    <div class="breadcrumbs-area">
        <h3>Professeurs</h3>
        <ul>
            <li><a href="{{ url('/') }}">Accueil</a></li>
            <li>Professeurs</li>
        </ul>
    </div>

    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Liste des professeurs</h3>
                </div>
                <div class="dropdown">
                    <a href="{{ route('teachers.create') }}" class="btn-fill-md text-light bg-gradient-yellow">
                        Ajouter un professeur
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table display data-table text-nowrap">
                    <thead>
                        <tr>
                            <th>Nom complet</th>
                            <th>École</th>
                            <th>Spécialité</th>
                            <th>Statut</th>
                            <th>Matières</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teachers as $teacher)
                            <tr>
                                <td>{{ $teacher->user->name }} {{ $teacher->user->first_name }}</td>
                                <td>{{ $teacher->school->name }}</td>
                                <td>{{ $teacher->speciality ?? '-' }}</td>
                                <td>
                                    <span class="badge badge-{{ $teacher->status === 'active' ? 'success' : 'danger' }}">
                                        {{ $teacher->status === 'active' ? 'Actif' : 'Inactif' }}
                                    </span>
                                </td>
                                <td>{{ $teacher->subjects->count() }}</td>
                                <td>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            <span class="flaticon-more-button-of-three-dots"></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="{{ route('teachers.show', $teacher) }}">
                                                <i class="fas fa-eye text-primary"></i> Voir
                                            </a>
                                            <a class="dropdown-item" href="{{ route('teachers.edit', $teacher) }}">
                                                <i class="fas fa-edit text-secondary"></i> Modifier
                                            </a>
                                            <a class="dropdown-item" href="{{ route('teachers.assign-subjects-form', $teacher) }}">
                                                <i class="fas fa-book text-info"></i> Assigner matières
                                            </a>
                                            <a class="dropdown-item" href="{{ route('teachers.schedule', $teacher) }}">
                                                <i class="fas fa-calendar-alt text-success"></i> Emploi du temps
                                            </a>
                                            <a class="dropdown-item" href="#"
                                               onclick="event.preventDefault(); document.getElementById('delete-form-{{ $teacher->id }}').submit();">
                                                <i class="fas fa-trash text-danger"></i> Supprimer
                                            </a>
                                            <form id="delete-form-{{ $teacher->id }}"
                                                  action="{{ route('teachers.destroy', $teacher) }}"
                                                  method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $teachers->links() }}
        </div>
    </div>
</div>
@endsection
