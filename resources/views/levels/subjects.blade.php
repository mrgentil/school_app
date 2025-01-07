@extends('layouts.main')

@section('content')
    <div class="container">
        <h1>Matières pour le Niveau : {{ $level->name }}</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Formulaire d'assignation -->
        <form method="POST" action="{{ route('levels.subjects.assign', 1) }}">
            @csrf
            <input type="hidden" name="subject_id" value="1">
            <input type="hidden" name="school_id" value="1">
            <input type="number" name="hours_per_week" min="1" value="5">
            <button type="submit">Assigner</button>
        </form>

        @csrf
            <div class="form-group">
                <label for="subject_id">Sélectionnez une matière :</label>
                <select name="subject_id" id="subject_id" class="form-control" required>
                    <option value="">-- Choisissez une matière --</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="school_id">École :</label>
                <select name="school_id" id="school_id" class="form-control" required>
                    <option value="">-- Choisissez une école --</option>
                    @foreach($schools as $school)
                        <option value="{{ $school->id }}">{{ $school->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="hours_per_week">Heures par semaine :</label>
                <input type="number" name="hours_per_week" id="hours_per_week" class="form-control" min="1" required>
            </div>

            <button type="submit" class="btn btn-success mt-3">Assigner la matière</button>
        </form>

        <!-- Liste des matières associées -->
        <h2 class="mt-5">Matières associées</h2>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Matière</th>
                <th>École</th>
                <th>Heures/Semaine</th>
            </tr>
            </thead>
            <tbody>
            @foreach($level->subjects as $subject)
                <tr>
                    <td>{{ $subject->name }}</td>
                    <td>{{ $subject->pivot->school_id }}</td>
                    <td>{{ $subject->pivot->hours_per_week }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
