@extends('layouts.main')
@section('title', isset($teacher) ? "Modifier le professeur" : "Ajouter un professeur")

@section('content')
<div class="dashboard-content-one">
    <div class="breadcrumbs-area">
        <h3>{{ isset($teacher) ? "Modifier le professeur" : "Ajouter un professeur" }}</h3>
        <ul>
            <li><a href="{{ url('/') }}">Accueil</a></li>
            <li><a href="{{ route('teachers.index') }}">Professeurs</a></li>
            <li>{{ isset($teacher) ? "Modifier" : "Ajouter" }}</li>
        </ul>
    </div>

    <div class="card height-auto">
        <div class="card-body">
            <form class="new-added-form" method="POST"
                  action="{{ isset($teacher) ? route('teachers.update', $teacher) : route('teachers.store') }}">
                @csrf
                @if(isset($teacher))
                    @method('PUT')
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Utilisateur <span class="text-danger">*</span></label>
                            <select name="user_id" class="select2 @error('user_id') is-invalid @enderror">
                                <option value="">Sélectionner un utilisateur</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ old('user_id', $teacher->user_id ?? '') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} {{ $user->first_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    @if(auth()->user()->role->name === 'Super Administrateur')
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>École <span class="text-danger">*</span></label>
                            <select name="school_id" class="select2 @error('school_id') is-invalid @enderror">
                                <option value="">Sélectionner une école</option>
                                @foreach($schools as $school)
                                    <option value="{{ $school->id }}"
                                        {{ old('school_id', $teacher->school_id ?? '') == $school->id ? 'selected' : '' }}>
                                        {{ $school->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('school_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    @endif

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Spécialité</label>
                            <input type="text" name="speciality"
                                   class="form-control @error('speciality') is-invalid @enderror"
                                   value="{{ old('speciality', $teacher->speciality ?? '') }}">
                            @error('speciality')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Statut</label>
                            <select name="status" class="form-control @error('status') is-invalid @enderror">
                                <option value="active" {{ old('status', $teacher->status ?? '') == 'active' ? 'selected' : '' }}>
                                    Actif
                                </option>
                                <option value="inactive" {{ old('status', $teacher->status ?? '') == 'inactive' ? 'selected' : '' }}>
                                    Inactif
                                </option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12 text-right">
                        <button type="submit" class="btn-fill-lg btn-gradient-yellow">Enregistrer</button>
                        <a href="{{ route('teachers.index') }}" class="btn-fill-lg bg-blue-dark">Retour</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
@endpush
