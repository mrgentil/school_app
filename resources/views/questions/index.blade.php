@extends('layouts.main')
@section('title', 'Liste Questions')
@section('meta_description')
    {{ "Liste des Questions" }}
@endsection
@section('content')
    <div class="dashboard-content-one">
        <!-- Breadcrumbs Area Start Here -->
        <div class="breadcrumbs-area">
            <h3>Questions</h3>
            <ul>
                <li>
                    <a href="{{ url('/') }}">Accueil</a>
                </li>
                <li>Liste des Questions</li>
            </ul>
        </div>
        <!-- Breadcrumbs Area End Here -->
        <!-- User Table Area Start Here -->
        <div class="card height-auto">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>Liste des Questions</h3>
                    </div>
                </div>
                <form class="mg-b-20" method="GET" action="{{ route('questions.index') }}">
                    <div class="row gutters-8">
                        <div class="col-6 col-lg-5 form-group">
                            <input type="text" name="query"
                                   value="{{ request('query') }}"
                                   placeholder="Recherche par Question ou Matière ..."
                                   class="form-control">
                        </div>
                        <div class="col-6 col-lg-3 form-group">
                            <button type="submit" class="fw-btn-fill btn-gradient-yellow btn-sm">Rechercher</button>
                            @if(request()->has('query'))
                                <a href="{{ route('questions.index') }}" class="fw-btn-fill btn-gradient-red btn-sm">Reset</a>
                            @endif
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table display data-table text-nowrap">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Question</th>
                            <th>Type</th>
                            <th>Examen</th>
                            <th>Matière</th>
                            <th>Actif</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($questions as $question)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $question->question }}</td>
                                <td>{{ $question->type }}</td>
                                <td>{{ $question->exam->title ?? 'N/A' }}</td>
                                <td>{{ $question->subject->name ?? 'N/A' }}</td>
                                <td>{{ $question->is_active ? 'Oui' : 'Non' }}</td>
                                <td>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            <span class="flaticon-more-button-of-three-dots"></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="{{ route('questions.edit', $question) }}">
                                                <i class="fas fa-cogs text-dark-pastel-green"></i> Modifier
                                            </a>
                                            <form action="{{ route('questions.destroy', $question) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette question ?');">
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
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Aucune question trouvée.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
