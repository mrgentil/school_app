@extends('layouts.main')
@section('title', isset($program) ? "Modifier le programme" : "Ajouter un programme")

@section('content')
    <div class="dashboard-content-one">
        <div class="breadcrumbs-area">
            <h3>{{ isset($program) ? "Modifier le programme" : "Ajouter un programme" }}</h3>
            <ul>
                <li><a href="{{ url('/') }}">Accueil</a></li>
                <li><a href="{{ route('classes.index') }}">Programme Scolaire</a></li>
                <li>{{ isset($program) ? "Modifier" : "Ajouter" }}</li>
            </ul>
        </div>

        <div class="card height-auto">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>{{ isset($program) ? "Modifier le programme" : "Nouveau programme" }}</h3>
                    </div>
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

                <form method="POST"
                      action="{{ isset($program) ? route('programmes.update', $program) : route('programmes.store') }}" enctype="multipart/form-data">
                    @csrf
                    @if(isset($program))
                        @method('PUT')
                    @endif

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="name">Intitulé du programme <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   value="{{ old('name', $program->name ?? '') }}"
                                   required>
                            @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        @if(auth()->user()->role->name === 'Super Administrateur')
                            <div class="col-md-6 form-group">
                                <label for="school_id">École <span class="text-danger">*</span></label>
                                <select class="form-control select2 @error('school_id') is-invalid @enderror"
                                        id="school_id"
                                        name="school_id"
                                        required>
                                    <option value="">Sélectionner une école</option>
                                    @foreach($schools as $school)
                                        <option value="{{ $school->id }}"
                                            {{ old('school_id', $program->school_id ?? '') == $school->id ? 'selected' : '' }}>
                                            {{ $school->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('school_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        @else
                            <input type="hidden" name="school_id" value="{{ auth()->user()->school_id }}">
                        @endif
                    </div>

                    <div class="col-lg-6 col-12 form-group mg-t-30">
                        <label class="text-dark-medium">Fichier</label>
                        <input type="file" name="file" class="form-control-file">
                    </div>

                    <div class="row">
                        <div class="col-12 form-group mg-t-8">
                            <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">
                                {{ isset($program) ? "Modifier" : "Ajouter" }}
                            </button>
                            <a href="{{ route('programmes.index') }}"
                               class="btn-fill-lg bg-blue-dark btn-hover-yellow">
                                Annuler
                            </a>
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
            $('.select2').select2({
                width: '100%'
            });
        });
    </script>
@endpush
