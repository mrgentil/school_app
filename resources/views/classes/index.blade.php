@extends('layouts.main')
@section('title', 'Liste Classes')
@section('meta_description')
    {{ "Formulaire d'ajout d'une nouvelle classe" }}
@endsection
@section('content')
    <div class="dashboard-content-one">
        <!-- Breadcubs Area Start Here -->
        <div class="breadcrumbs-area">
            <h3>Classes</h3>
            <ul>
                <li>
                    <a href="{{ url('/') }}">Accueil</a>
                </li>
                <li>Les Classes</li>
            </ul>
        </div>
        <!-- Breadcubs Area End Here -->
        <!-- User Table Area Start Here -->
        <div class="card height-auto">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>Liste Classe</h3>
                    </div>
                </div>
                <form class="mg-b-20">
                    <div class="row gutters-8">
                        <div class="col-4-xxxl col-xl-4 col-lg-3 col-12 form-group">
                            <input type="text" placeholder="Recherche par Nom ..." class="form-control">
                        </div>
                        <div class="col-4-xxxl col-xl-3 col-lg-3 col-12 form-group">
                            <input type="text" placeholder="Recherche par Ecole ..." class="form-control">
                        </div>
                        <div class="col-1-xxxl col-xl-2 col-lg-3 col-12 form-group">
                            <button type="submit" class="fw-btn-fill btn-gradient-yellow">Rechercher</button>
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
                        @foreach ($classes as $classe)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $classe->name }}</td>
                                <td>{{ $classe->school->name }}</td>
                                <td>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                           aria-expanded="false">
                                            <span class="flaticon-more-button-of-three-dots"></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            @can('update', $classe)
                                                <a class="dropdown-item" href="{{ route('classes.edit', $classe->id) }}">
                                                    <i class="fas fa-cogs text-dark-pastel-green"></i> Modifier
                                                </a>
                                            @endcan
                                            <form action="{{ route('classes.destroy', $classe->id) }}" method="POST"
                                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette classe ?');">
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
