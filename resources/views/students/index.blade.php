@extends('layouts.main')
@section('title', 'Liste des élèves')

@section('content')
    <div class="dashboard-content-one">
        <div class="breadcrumbs-area">
            <h3>Élèves</h3>
            <ul>
                <li><a href="{{ url('/') }}">Accueil</a></li>
                <li>Liste des élèves</li>
            </ul>
        </div>

        <div class="card height-auto">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>Liste des élèves</h3>
                    </div>
                    @can('create', App\Models\Student::class)
                        <div class="dropdown">
                            <a href="{{ route('students.create') }}" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">
                                Ajouter un élève
                            </a>
                        </div>
                    @endcan
                </div>

                <form class="mg-b-20">
                    <div class="row gutters-8">
                        <div class="col-lg-4 col-12 form-group">
                            <input type="text" name="search"
                                   placeholder="Rechercher par nom ou numéro..."
                                   class="form-control"
                                   value="{{ request('search') }}">
                        </div>
                        @if(auth()->user()->role->name === 'Super Administrateur')
                            <div class="col-lg-3 col-12 form-group">
                                <select name="school_id" class="form-control select2">
                                    <option value="">Toutes les écoles</option>
                                    @foreach($schools as $school)
                                        <option value="{{ $school->id }}"
                                            {{ request('school_id') == $school->id ? 'selected' : '' }}>
                                            {{ $school->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div class="col-lg-2 col-12 form-group">
                            <button type="submit" class="fw-btn-fill btn-gradient-yellow">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table display data-table text-nowrap">
                        <thead>
                        <tr>
                            <th>N° Inscription</th>
                            <th>Nom</th>
                            <th>École</th>
                            <th>Classe</th>
                            <th>Option</th>
                            <th>Promotion</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($students as $student)
                            <tr>
                                <td>{{ $student->registration_number }}</td>
                                <td>{{ $student->user->name }}</td>
                                <td>{{ $student->school->name }}</td>
                                <td>{{ $student->class->name }}</td>
                                <td>{{ $student->option->name ?? 'N/A' }}</td>
                                <td>{{ $student->promotion->name }}</td>
                                <td>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                            <span class="flaticon-more-button-of-three-dots"></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            @can('view', $student)
                                                <a class="dropdown-item" href="{{ route('students.show', $student) }}">
                                                    <i class="fas fa-eye text-primary"></i> Voir
                                                </a>
                                            @endcan
                                            @can('update', $student)
                                                <a class="dropdown-item" href="{{ route('students.edit', $student) }}">
                                                    <i class="fas fa-edit text-dark-pastel-green"></i> Modifier
                                                </a>
                                            @endcan

                                            @can('delete', $student)
                                                <form action="{{ route('students.destroy', $student) }}" method="POST"
                                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet élève ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="fas fa-trash text-orange-red"></i> Supprimer
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
{{--                {{ $students->links() }}--}}
            </div>
        </div>
    </div>
@endsection
