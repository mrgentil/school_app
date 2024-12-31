@extends('layouts.main')
@section('title', 'Liste Historique Eleve')
@section('meta_description')
    {{ "Formulaire d'ajout d'un nouveau historique" }}
@endsection
@section('content')
    <div class="dashboard-content-one">
        <!-- Breadcubs Area Start Here -->
        <div class="breadcrumbs-area">
            <h3>Historique</h3>
            <ul>
                <li>
                    <a href="{{ url('/') }}">Accueil</a>
                </li>
                <li>Les Historiques</li>
            </ul>
        </div>
        <!-- Breadcubs Area End Here -->
        <!-- User Table Area Start Here -->
        <div class="card height-auto">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>Liste Historique Elève</h3>
                    </div>
                    @can('create', App\Models\StudentHistory::class)
                        <div class="dropdown">
                            <a href="{{ route('histories.create') }}"
                               class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">
                                Ajouter un historique
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
                            <th>#</th>
                            <th>Nom Elève</th>
                            <th>Nom Ecole</th>
                            <th>Classe</th>
                            <th>Année Scolaire</th>
                            <th>Semestre</th>
                            <th>Note</th>
                            <th>Décision</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($histories as $history)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $history->student->user->name }}</td>
                                <td>{{ $history->school->name }}</td>
                                <td>{{ $history->class->name }}</td>
                                <td>{{ $history->academic_year }}</td>
                                <td>{{ $history->semester }}</td>
                                <td>{{ $history->average_score ?? '-' }}/20</td>
                                <td>
                                    <span
                                        class="badge {{ $history->decision === 'Admis' ? 'badge-success' : 'badge-warning' }}">
                                        {{ $history->decision }}
                                    </span>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                           aria-expanded="false">
                                            <span class="flaticon-more-button-of-three-dots"></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            @can('view', $history)
                                                <a class="dropdown-item" href="{{ route('histories.show', $history) }}">
                                                    <i class="fas fa-eye text-primary"></i> Voir détails
                                                </a>
                                            @endcan
                                            @can('update', $history)
                                                <a class="dropdown-item" href="{{ route('histories.edit', $history) }}">
                                                    <i class="fas fa-cogs text-dark-pastel-green"></i> Modifier
                                                </a>
                                            @endcan
                                            @can('delete', $history)
                                                <form action="{{ route('histories.destroy', $history) }}" method="POST"
                                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet historique ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="fas fa-times text-orange-red"></i> Supprimer
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
            </div>
        </div>
    </div>
@endsection
