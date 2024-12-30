@extends('layouts.main')
@section('title', "Historique de l'élève " . $student->user->name)

@section('content')
    <div class="dashboard-content-one">
        <div class="breadcrumbs-area">
            <h3>Historique de l'élève</h3>
            <ul>
                <li><a href="{{ url('/') }}">Accueil</a></li>
                <li><a href="{{ route('students.index') }}">Élèves</a></li>
                <li>Historique</li>
            </ul>
        </div>

        <div class="card height-auto">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>Historique de {{ $student->user->name }} {{ $student->user->first_name }}</h3>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table display data-table text-nowrap">
                        <thead>
                        <tr>
                            <th>Date de début</th>
                            <th>École</th>
                            <th>Classe</th>
                            <th>Option</th>
                            <th>Promotion</th>
                            <th>Statut</th>
                            <th>Notes</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($histories as $history)
                            <tr>
                                <td>{{ $history->start_date ? date('d/m/Y', strtotime($history->start_date)) : '-' }}</td>
                                <td>{{ $history->school->name }}</td>
                                <td>{{ $history->class->name }}</td>
                                <td>{{ $history->option->name ?? '-' }}</td>
                                <td>{{ $history->promotion->name }}</td>
                                <td>{{ $history->status }}</td>
                                <td>{{ $history->notes ?? '-' }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
