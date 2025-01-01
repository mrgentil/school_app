@extends('layouts.main')
@section('title', isset($class) ? "Modifier la classe" : "Ajouter une classe")

@section('content')
<div class="dashboard-content-one">
    <div class="breadcrumbs-area">
        <h3>{{ isset($class) ? "Modifier la classe" : "Ajouter une classe" }}</h3>
        <ul>
            <li><a href="{{ url('/') }}">Accueil</a></li>
            <li><a href="{{ route('classes.index') }}">Classes</a></li>
            <li>{{ isset($class) ? "Modifier" : "Ajouter" }}</li>
        </ul>
    </div>

    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>{{ isset($class) ? "Modifier la classe" : "Nouvelle classe" }}</h3>
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
                  action="{{ isset($class) ? route('classes.update', $class) : route('classes.store') }}">
                @csrf
                @if(isset($class))
                    @method('PUT')
                @endif

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="name">Nom de la classe <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               id="name"
                               name="name"
                               value="{{ old('name', $class->name ?? '') }}"
                               required>
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="section">Section</label>
                        <input type="text"
                               class="form-control @error('section') is-invalid @enderror"
                               id="section"
                               name="section"
                               value="{{ old('section', $class->section ?? '') }}">
                        @error('section')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="option_id">Option</label>
                        <select class="form-control select2 @error('option_id') is-invalid @enderror"
                                id="option_id"
                                name="option_id">
                            <option value="">Sélectionner une option</option>
                            @foreach($options as $option)
                                <option value="{{ $option->id }}"
                                    {{ old('option_id', $class->option_id ?? '') == $option->id ? 'selected' : '' }}>
                                    {{ $option->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('option_id')
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
                                        {{ old('school_id', $class->school_id ?? '') == $school->id ? 'selected' : '' }}>
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

                <div class="row">
                    <div class="col-12 form-group mg-t-8">
                        <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">
                            {{ isset($class) ? "Modifier" : "Ajouter" }}
                        </button>
                        <a href="{{ route('classes.index') }}"
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
    $(document).ready(function() {
        $('.select2').select2({
            width: '100%'
        });
    });
</script>
@endpush
