@extends('layouts.main')
@section('title', 'Liste Examens')
@section('meta_description')
    {{ "Liste Examens" }}
@endsection
@section('content')
    <div class="dashboard-content-one">
        <!-- Breadcubs Area Start Here -->
        <div class="breadcrumbs-area">
            <h3>Examens</h3>
            <ul>
                <li>
                    <a href="{{ url('/') }}">Accueil</a>
                </li>
                <li>Les Examens</li>
            </ul>
        </div>
        <!-- Breadcubs Area End Here -->
        <!-- User Table Area Start Here -->
        <div class="card height-auto">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>Liste Examens</h3>
                    </div>
                </div>
                <form class="mg-b-20" method="GET" action="{{ route('exams.index') }}">
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
                                <a href="{{ route('exams.index') }}" class="fw-btn-fill btn-gradient-red btn-sm">Reset</a>
                            @endif
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table display data-table text-nowrap">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Titre</th>
                            <th>Date de l'examen</th>
                            <th>Durée</th>
                            <th>Classe</th>
                            <th>Matière</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($exams as $exam)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $exam->title }}</td>
                                <td>{{ \Carbon\Carbon::parse($exam->exam_date)->translatedFormat('l, d F Y') }}</td>
                                <td>{{ $exam->duration }}'</td>
                                <td>{{ $exam->class->name }}</td>
                                <td>{{ $exam->subject->name }}</td>
                                <td>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                           aria-expanded="false">
                                            <span class="flaticon-more-button-of-three-dots"></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="{{ route('exams.show', $exam->id) }}">
                                                <i class="fas fa-eye"></i> Voir
                                            </a>
                                            @can('update', $exam)
                                                <a class="dropdown-item" href="{{ route('exams.edit', $exam->id) }}">
                                                    <i class="fas fa-cogs text-dark-pastel-green"></i> Modifier
                                                </a>
                                            @endcan
                                            <form action="{{ route('exams.destroy', $exam->id) }}" method="POST"
                                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet examen ?');">
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
