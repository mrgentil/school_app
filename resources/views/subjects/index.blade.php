@extends('layouts.main')
@section('title', 'Liste des matières')

@section('content')
<div class="dashboard-content-one">
    <div class="breadcrumbs-area">
        <h3>Matières</h3>
        <ul>
            <li><a href="{{ url('/') }}">Accueil</a></li>
            <li>Matières</li>
        </ul>
    </div>

    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Liste des matières</h3>
                </div>
                <div class="dropdown">
                    <a href="{{ route('subjects.create') }}" class="btn-fill-md text-light bg-gradient-yellow">
                        Ajouter une matière
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table display data-table text-nowrap">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Nom</th>
                            <th>École</th>
                            <th>Description</th>
                            <th>Professeurs</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($subjects as $subject)
                            <tr>
                                <td>{{ $subject->code }}</td>
                                <td>{{ $subject->name }}</td>
                                <td>{{ $subject->school->name }}</td>
                                <td>{{ Str::limit($subject->description, 50) }}</td>
                                <td>{{ $subject->teachers->count() }}</td>
                                <td>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            <span class="flaticon-more-button-of-three-dots"></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="{{ route('subjects.show', $subject) }}">
                                                <i class="fas fa-eye text-primary"></i> Voir
                                            </a>
                                            <a class="dropdown-item" href="{{ route('subjects.edit', $subject) }}">
                                                <i class="fas fa-edit text-secondary"></i> Modifier
                                            </a>
                                            <a class="dropdown-item" href="#"
                                               onclick="event.preventDefault();
                                                        if(confirm('Voulez-vous vraiment dupliquer cette matière ?')) {
                                                            document.getElementById('duplicate-form-{{ $subject->id }}').submit();
                                                        }">
                                                <i class="fas fa-copy text-info"></i> Dupliquer
                                            </a>
                                            <a class="dropdown-item" href="#"
                                               onclick="event.preventDefault();
                                                        if(confirm('Voulez-vous vraiment supprimer cette matière ?')) {
                                                            document.getElementById('delete-form-{{ $subject->id }}').submit();
                                                        }">
                                                <i class="fas fa-trash text-danger"></i> Supprimer
                                            </a>
                                            <form id="duplicate-form-{{ $subject->id }}"
                                                  action="{{ route('subjects.duplicate', $subject) }}"
                                                  method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                            <form id="delete-form-{{ $subject->id }}"
                                                  action="{{ route('subjects.destroy', $subject) }}"
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
            {{ $subjects->links() }}
        </div>
    </div>
</div>
@endsection
