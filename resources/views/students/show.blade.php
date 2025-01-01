@extends('layouts.main')
@section('title', "Détails de l'élève " . $student->user->name)

@section('content')
    <div class="dashboard-content-one">
        <div class="breadcrumbs-area">
            <h3>Détails de l'élève</h3>
            <ul>
                <li><a href="{{ url('/') }}">Accueil</a></li>
                <li><a href="{{ route('students.index') }}">Élèves</a></li>
                <li>Détails</li>
            </ul>
        </div>

        <div class="card height-auto">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>Informations de l'élève</h3>
                    </div>
                    <div class="dropdown">
                        <a href="{{ route('students.edit', $student) }}" class="btn-fill-md text-light bg-gradient-yellow">
                            Modifier
                        </a>
                    </div>
                </div>

                <div class="single-info-details">
                    <div class="item-content">
                        <div class="info-table table-responsive">
                            <table class="table text-nowrap">
                                <tbody>
                                <tr>
                                    <td>Nom complet:</td>
                                    <td>{{ $student->user->name }} {{ $student->user->first_name }}</td>
                                </tr>
                                <tr>
                                    <td>N° d'inscription:</td>
                                    <td>{{ $student->registration_number }}</td>
                                </tr>
                                <tr>
                                    <td>École:</td>
                                    <td>{{ $student->school->name }}</td>
                                </tr>
                                <tr>
                                    <td>Classe:</td>
                                    <td>{{ $student->class->name }}</td>
                                </tr>
                                <tr>
                                    <td>Option:</td>
                                    <td>{{ $student->option->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>Promotion:</td>
                                    <td>{{ $student->promotion->name }}</td>
                                </tr>
                                <tr>
                                    <td>Email:</td>
                                    <td>{{ $student->user->email }}</td>
                                </tr>
                                <tr>
                                    <td>Téléphone:</td>
                                    <td>{{ $student->user->phone ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>Adresse:</td>
                                    <td>{{ $student->user->adress }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                @if($student->histories->isNotEmpty())
                    <div class="heading-layout1 mt-5">
                        <div class="item-title">
                            <h3>Historique</h3>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table display data-table text-nowrap">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>École</th>
                                <th>Classe</th>
                                <th>Option</th>
                                <th>Promotion</th>
                                <th>Notes</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($student->histories as $history)
                                <tr>
                                    <td>
                                        @if($history->start_date instanceof \Carbon\Carbon)
                                            {{ $history->start_date->format('d/m/Y') }}
                                        @else
                                            {{ \Carbon\Carbon::parse($history->start_date)->format('d/m/Y') }}
                                        @endif
                                    </td>
                                    <td>{{ $history->school->name }}</td>
                                    <td>{{ $history->class->name }}</td>
                                    <td>{{ $history->option->name ?? '-' }}</td>
                                    <td>{{ $history->promotion->name }}</td>
                                    <td>{{ $history->notes ?? '-' }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
