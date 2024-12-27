@extends('layouts.main')
@section('title', 'Liste Options')
@section('meta_description')
    {{ "Formulaire d'ajout d'une nouvelle option" }}
@endsection
@section('content')
    <div class="dashboard-content-one">
        <!-- Breadcubs Area Start Here -->
        <div class="breadcrumbs-area">
            <h3>Options Scolaire</h3>
            <ul>
                <li>
                    <a href="{{ url('/') }}">Accueil</a>
                </li>
                <li>Les Options</li>
            </ul>
        </div>
        <!-- Breadcubs Area End Here -->
        <!-- User Table Area Start Here -->
        <div class="card height-auto">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>Liste Option</h3>
                    </div>
                </div>
                <form class="mg-b-20" method="GET" action="{{ route('options.index') }}">
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
                                placeholder="Recherche par École ..."
                                class="form-control">
                        </div>
                        <div class="col-2-xxxl col-xl-2 col-lg-2 col-12 form-group d-flex">
                            <button type="submit" class="fw-btn-fill btn-gradient-yellow btn-sm mr-2">
                                <i class="fas fa-search"></i>
                            </button>
                            @if(request()->hasAny(['name', 'school']))
                                <a href="{{ route('options.index') }}" class="fw-btn-fill btn-gradient-red btn-sm">
                                    <i class="fas fa-times"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table display data-table text-nowrap">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Ecole</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($options as $option)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $option->name }}</td>
                                <td>{{ $option->school->name }}</td>
                                <td>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                           aria-expanded="false">
                                            <span class="flaticon-more-button-of-three-dots"></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            @can('update', $option)
                                                <a class="dropdown-item" href="{{ route('options.edit', $option->id) }}">
                                                    <i class="fas fa-cogs text-dark-pastel-green"></i> Modifier
                                                </a>
                                            @endcan
                                            <form action="{{ route('options.destroy', $option->id) }}" method="POST"
                                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette option ?');">
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
