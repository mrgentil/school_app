@extends('layouts.main')
@section('title', "Détails de l'historique")

@section('content')
    <div class="dashboard-content-one">
        <div class="breadcrumbs-area">
            <h3>Détails de l'historique</h3>
            <ul>
                <li><a href="{{ url('/') }}">Accueil</a></li>
                <li><a href="{{ route('histories.index') }}">Historiques</a></li>
                <li>Détails</li>
            </ul>
        </div>

        <div class="card height-auto">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>Informations de l'historique</h3>
                    </div>
                    <div class="dropdown">
                        @can('update', $history)
                            <a href="{{ route('histories.edit', $history) }}"
                               class="btn-fill-md btn-gradient-yellow btn-hover-bluedark">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                        @endcan
                    </div>
                </div>

                <!-- Informations de l'élève -->
                <div class="single-info-details">
                    <div class="item-content">
                        <div class="header-inline mb-4">
                            <h3 class="text-dark-medium font-medium">Informations de l'élève</h3>
                        </div>
                        <div class="info-table table-responsive">
                            <table class="table text-nowrap">
                                <tbody>
                                    <tr>
                                        <td>Nom complet:</td>
                                        <td>{{ $history->student->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Matricule:</td>
                                        <td>{{ $history->student->registration_number }}</td>
                                    </tr>
                                    <tr>
                                        <td>École:</td>
                                        <td>{{ $history->school->name }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Informations académiques -->
                <div class="single-info-details mt-4">
                    <div class="item-content">
                        <div class="header-inline mb-4">
                            <h3 class="text-dark-medium font-medium">Informations académiques</h3>
                        </div>
                        <div class="info-table table-responsive">
                            <table class="table text-nowrap">
                                <tbody>
                                    <tr>
                                        <td>Année académique:</td>
                                        <td>{{ $history->academic_year }}</td>
                                    </tr>
                                    <tr>
                                        <td>Semestre:</td>
                                        <td>{{ $history->semester }}</td>
                                    </tr>
                                    <tr>
                                        <td>Classe:</td>
                                        <td>{{ $history->class->name }}</td>
                                    </tr>
                                    @if($history->option)
                                        <tr>
                                            <td>Option:</td>
                                            <td>{{ $history->option->name }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Résultats -->
                <div class="single-info-details mt-4">
                    <div class="item-content">
                        <div class="header-inline mb-4">
                            <h3 class="text-dark-medium font-medium">Résultats</h3>
                        </div>
                        <div class="info-table table-responsive">
                            <table class="table text-nowrap">
                                <tbody>
                                    <tr>
                                        <td>Moyenne:</td>
                                        <td>{{ $history->average_score ? $history->average_score . '/20' : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Rang:</td>
                                        <td>{{ $history->rank ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Décision:</td>
                                        <td>
                                            <span class="badge {{ $history->decision === 'Admis' ? 'badge-success' : 'badge-warning' }}">
                                                {{ $history->decision }}
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Comportement et remarques -->
                <div class="single-info-details mt-4">
                    <div class="item-content">
                        <div class="header-inline mb-4">
                            <h3 class="text-dark-medium font-medium">Comportement et remarques</h3>
                        </div>
                        <div class="info-table table-responsive">
                            <table class="table text-nowrap">
                                <tbody>
                                    <tr>
                                        <td>Note de conduite:</td>
                                        <td>{{ $history->conduct_grade ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Assiduité:</td>
                                        <td>{{ $history->attendance_record ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Remarques des enseignants:</td>
                                        <td>{{ $history->teacher_remarks ?? '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Dates -->
                <div class="single-info-details mt-4">
                    <div class="item-content">
                        <div class="header-inline mb-4">
                            <h3 class="text-dark-medium font-medium">Informations système</h3>
                        </div>
                        <div class="info-table table-responsive">
                            <table class="table text-nowrap">
                                <tbody>
                                    <tr>
                                        <td>Créé le:</td>
                                        <td>{{ $history->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Dernière modification:</td>
                                        <td>{{ $history->updated_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Statut:</td>
                                        <td>
                                            <span class="badge {{ $history->status === 'active' ? 'badge-success' : 'badge-secondary' }}">
                                                {{ $history->status === 'active' ? 'Actif' : 'Inactif' }}
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="mt-4">
                    <a href="{{ route('histories.index') }}" class="btn-fill-lg bg-blue-dark btn-hover-yellow">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>

                    @can('delete', $history)
                        <form action="{{ route('histories.destroy', $history) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet historique ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-fill-lg bg-gradient-gplus btn-hover-yellow">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection
