@extends('layouts.main')

@section('content')
    <div class="dashboard-content-one">
        <!-- Breadcubs Area Start Here -->
        <div class="breadcrumbs-area">
            <h3>Ecoles</h3>
            <ul>
                <li>
                    <a href="{{ url('/') }}">Accueil</a>
                </li>
                <li>Les Ecoles</li>
            </ul>
        </div>
        <!-- Breadcubs Area End Here -->
        <!-- User Table Area Start Here -->
        <div class="card height-auto">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>Liste Ecoles</h3>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table display data-table text-nowrap">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Logo</th>
                            <th>Nom</th>
                            <th>Adresse</th>

                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($schools as $school)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-center">
                                    @if ($school->logo)
                                        <img src="{{ asset('storage/' . $school->logo) }}" alt="Logo" class="rounded-circle" style="width: 50px; height: 50px;">

                                         @else
                                                                    @php
                                                                        $initials = strtoupper(substr($school->name, 0, 1)) . strtoupper(substr($school->name, strpos($school->name, ' ') + 1, 1));
                                                                        $colors = ['#FF5733', '#33FF57', '#3357FF', '#F333FF', '#FFAF33'];
                                                                      $bgColor = $colors[array_rand($colors)];
                                                                    @endphp
                                        <div class="generated-avatar" style="background-color: {{ $bgColor }};">
                                                                        {{ $initials }}
                                                                    </div>
                                                                @endif
                                </td>
                                <td>{{ $school->name }}</td>

                                <td>{{ $school->adress ?? 'N/A' }}</td>

                                <td>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            <span class="flaticon-more-button-of-three-dots"></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="{{ route('schools.edit', $school->id) }}">
                                                <i class="fas fa-cogs text-dark-pastel-green"></i> Modifier
                                            </a>
                                            <form action="{{ route('schools.destroy', $school->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette école ?');">
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

