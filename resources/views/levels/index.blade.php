@extends('layouts.main')

@section('content')
    <div class="container">
        <h1>Liste des Niveaux Scolaires</h1>
        <ul class="list-group">
            @foreach($levels as $level)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $level->name }}
                    <a href="{{ route('levels.subjects.show', $level->id) }}" class="btn btn-primary btn-sm">
                        Voir les matières
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
