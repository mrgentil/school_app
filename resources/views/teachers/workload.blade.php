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
                            <th>Nom de l'enseignant</th>
                            <th>Charge horaire totale</th>
                            <th>Surcharge</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($teachers as $teacher)
                            <tr>
                                <td>{{ $teacher['name'] }}</td>
                                <td>{{ $teacher['totalWorkload'] }} heures</td>
                                <td>{{ $teacher['isOverloaded'] ? 'Oui' : 'Non' }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
