@extends('layouts.main')
@section('title', isset($subject) ? "Modifier la matière" : "Ajouter une matière")

@section('content')
    <div class="dashboard-content-one">
        <div class="breadcrumbs-area">
            <h3>{{ isset($subject) ? "Modifier la matière" : "Ajouter une matière" }}</h3>
            <ul>
                <li><a href="{{ url('/') }}">Accueil</a></li>
                <li><a href="{{ route('subjects.index') }}">Matières</a></li>
                <li>{{ isset($subject) ? "Modifier" : "Ajouter" }}</li>
            </ul>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card height-auto">
            <div class="card-body">
                <form class="new-added-form" method="POST"
                      action="{{ isset($subject) ? route('subjects.update', $subject) : route('subjects.store') }}">
                    @csrf
                    @if(isset($subject))
                        @method('PUT')
                    @endif

                    <div class="row">
                        <!-- Champs existants -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nom <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $subject->name ?? '') }}">
                                @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <!-- Nouveau champ pour la classe -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Classes <span class="text-danger">*</span></label>
                                <select name="class_ids[]" multiple class="select2 @error('class_ids') is-invalid @enderror">
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}"
                                        @if(isset($subject))
                                            {{ in_array($class->id, old('class_ids', $subject->classes->pluck('id')->toArray())) ? 'selected' : '' }}
                                            @else
                                            {{ in_array($class->id, old('class_ids', [])) ? 'selected' : '' }}
                                            @endif
                                        >
                                            {{ $class->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('class_ids')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="form-text text-muted">
                                    Maintenez Ctrl (Windows) ou Cmd (Mac) pour sélectionner plusieurs classes
                                </small>
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
                                                {{ old('school_id', $subject->school_id ?? '') == $school->id ? 'selected' : '' }}>
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

                        <div class="col-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                          rows="3">{{ old('description', $subject->description ?? '') }}</textarea>
                                @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12 text-right">
                            <button type="submit" class="btn-fill-lg btn-gradient-yellow">Enregistrer</button>
                            <a href="{{ route('subjects.index') }}" class="btn-fill-lg bg-blue-dark">Retour</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('.select2').select2();
        });
    </script>
@endpush
