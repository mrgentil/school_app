@extends('layouts.main')
@section('title', 'Liste Utilisateurs')
@section('meta_description')
    {{ "Formulaire d'ajout d'un nouvel utilisateur" }}
@endsection
@section('content')
    <div class="dashboard-content-one">
        <!-- Breadcubs Area Start Here -->
        <div class="breadcrumbs-area">
            <h3>Utilisateurs</h3>
            <ul>
                <li>
                    <a href="{{ url('/') }}">Accueil</a>
                </li>
                <li>Les Utilisateurs</li>
            </ul>
        </div>
        <!-- Breadcubs Area End Here -->
        <!-- User Table Area Start Here -->
        <div class="card height-auto">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>Liste Utilisateur</h3>
                    </div>
                </div>
                <form class="mg-b-20" method="GET" action="{{ route('users.index') }}">
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
                                <a href="{{ route('users.index') }}" class="fw-btn-fill btn-gradient-red btn-sm">Reset</a>
                            @endif
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table display data-table text-nowrap">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Avatar</th>
                            <th>Nom</th>
                            <th>Postnom</th>
                            <th>Prénom</th>
                            <th>Genre</th>
                            <th>Email</th>
                            <th>Adresse</th>
                            <th>Téléphone</th>
                            <th>Role</th>
                            <th>Ecole</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-center">
                                    @if ($user->avatar)
                                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar"
                                             class="rounded-circle" style="width: 50px; height: 50px;">

                                    @else
                                        @php
                                            $initials = strtoupper(substr($user->name, 0, 1)) . strtoupper(substr($user->name, strpos($user->name, ' ') + 1, 1));
                                            $colors = ['#FF5733', '#33FF57', '#3357FF', '#F333FF', '#FFAF33'];
                                          $bgColor = $colors[array_rand($colors)];
                                        @endphp
                                        <div class="generated-avatar" style="background-color: {{ $bgColor }};">
                                            {{ $initials }}
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->first_name }}</td>
                                <td>{{ $user->last_name }}</td>
                                <td class="text-center">
                                    @if($user->gender === 'Masculin')
                                        <div class="gender-avatar-custom male" title="Masculin">
                                            <img src="{{ asset('img/figure/student2.png') }}" alt="Masculin">
                                        </div>
                                    @elseif($user->gender === 'Féminin')
                                        <div class="gender-avatar-custom female" title="Féminin">
                                            <img src="{{ asset('img/figure/student3.png') }}" alt="Féminin">
                                        </div>
                                    @else
                                        {{ $user->gender }}
                                    @endif
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->adress }}</td>
                                <td>{{ $user->phone ?? 'N/A' }}</td>
                                <td>{{ $user->role->name }}</td>
                                <td>{{ $user->school->name }}</td>
                                <td>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                           aria-expanded="false">
                                            <span class="flaticon-more-button-of-three-dots"></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            @can('update', $user)
                                                <a class="dropdown-item" href="{{ route('users.edit', $user->id) }}">
                                                    <i class="fas fa-cogs text-dark-pastel-green"></i> Modifier
                                                </a>
                                            @endcan
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
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
