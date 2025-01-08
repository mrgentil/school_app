@extends('layouts.main')
@section('title', 'Liste Horaire')
@section('meta_description')
    {{ "Formulaire d'ajout d'un nouvel horaire" }}
@endsection
@section('content')
    <div class="dashboard-content-one">
        <!-- Breadcubs Area Start Here -->
        <div class="breadcrumbs-area">
            <h3>Horaires</h3>
            <ul>
                <li>
                    <a href="{{ url('/') }}">Accueil</a>
                </li>
                <li>Les Horaires des cours</li>
            </ul>
        </div>
        <!-- Breadcubs Area End Here -->
        <!-- User Table Area Start Here -->
        <div class="card height-auto">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>Liste Horaires</h3>
                    </div>
                </div>
                <form class="mg-b-20" method="GET" action="{{ route('schedules.index') }}">
                    <div class="row gutters-8">
                        <div class="col-5-xxxl col-xl-5 col-lg-5 col-12 form-group">
                            <input type="text" name="name"
                                   value="{{ request('name') }}"
                                   placeholder="Recherche par Nom ..."
                                   class="form-control">
                        </div>
                        <div class="col-5-xxxl col-xl-5 col-lg-5 col-12 form-group">
                            <input type="text" name="school"
                                   value="{{ request('school') }}"
                                   placeholder="Recherche par Ecole ..."
                                   class="form-control">
                        </div>
                        <div class="col-2-xxxl col-xl-2 col-lg-2 col-12 form-group d-flex align-items-center">
                            <button type="submit" class="fw-btn-fill btn-gradient-yellow btn-sm mr-2">Rechercher</button>
                            @if(request()->hasAny(['name', 'school']))
                                <a href="{{ route('schedules.index') }}" class="fw-btn-fill btn-gradient-red btn-sm">Reset</a>
                            @endif
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table display data-table text-nowrap">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Classe</th>
                            <th>Matière</th>
                            <th>Professeur</th>
                            <th>Jour</th>
                            <th>Heure Début</th>
                            <th>Heure Fin</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($schedules as $schedule)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $schedule->class->name }}</td>
                                <td>{{ $schedule->subject->name }}</td>
                                <<td>{{ $schedule->teacher ? $schedule->teacher->name : 'Professeur non attribué' }}</td>
                                <td>{{ $schedule->day_of_week }}</td>
                                <td>{{ $schedule->start_time }}</td>
                                <td>{{ $schedule->end_time }}</td>
                                <td>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                           aria-expanded="false">
                                            <span class="flaticon-more-button-of-three-dots"></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            @can('update', $schedule)
                                                <a class="dropdown-item" href="{{ route('schedules.edit', $schedule->id) }}">
                                                    <i class="fas fa-cogs text-dark-pastel-green"></i> Modifier
                                                </a>
                                            @endcan
                                            <form action="{{ route('schedules.destroy', $schedule->id) }}" method="POST"
                                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet horaire ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item">
                                                    <i class="fas fa-times text-orange-red"></i> Supprimer
                                                </button>
                                            </form>
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
