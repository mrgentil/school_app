@extends('layouts.main')
@section('title', 'Assigner une matière')
@section('content')
    <div class="dashboard-content-one">
        <!-- Breadcubs Area Start Here -->
        <div class="breadcrumbs-area">
            <h3>Assigner une matière</h3>
            <ul>
                <li><a href="{{ url('/') }}">Accueil</a></li>
                <li>Assigner une matière</li>
            </ul>
        </div>
        <!-- Breadcubs Area End Here -->
        <!-- Add New Teacher Area Start Here -->
        <div class="card height-auto">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>Assigner des matières à un professeur</h3>
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

                <form method="POST" action="{{ route('teachers.assign') }}" class="new-added-form">
                    @csrf
                    <div class="row">
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Professeur <span class="text-danger">*</span></label>
                            <select name="teacher_id" class="select2 @error('teacher_id') is-invalid @enderror">
                                <option value="">Sélectionner un professeur</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}"
                                        {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                        {{ $teacher->user->name }} {{ $teacher->user->first_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('teacher_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Année académique <span class="text-danger">*</span></label>
                            <select name="academic_year"
                                    class="form-control @error('academic_year') is-invalid @enderror">
                                @php
                                    $currentYear = date('Y');
                                    $nextYear = $currentYear + 1;
                                    $prevYear = $currentYear - 1;
                                @endphp
                                <option value="{{ $prevYear }}-{{ $currentYear }}">
                                    {{ $prevYear }}-{{ $currentYear }}
                                </option>
                                <option value="{{ $currentYear }}-{{ $nextYear }}" selected>
                                    {{ $currentYear }}-{{ $nextYear }}
                                </option>
                            </select>
                            @error('academic_year')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Matières <span class="text-danger">*</span></label>
                            <select name="subjects[]" multiple class="select2 @error('subjects') is-invalid @enderror">
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}"
                                        {{ (is_array(old('subjects')) && in_array($subject->id, old('subjects'))) ? 'selected' : '' }}>
                                        {{ $subject->name }} ({{ $subject->code }})
                                    </option>
                                @endforeach
                            </select>
                            @error('subjects')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">
                                Maintenez Ctrl (Windows) ou Cmd (Mac) pour sélectionner plusieurs matières
                            </small>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Classes <span class="text-danger">*</span></label>
                            <select name="classes[]" multiple class="select2 @error('classes') is-invalid @enderror">
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}"
                                        {{ (is_array(old('classes')) && in_array($class->id, old('classes'))) ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('classes')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">
                                Maintenez Ctrl (Windows) ou Cmd (Mac) pour sélectionner plusieurs classes
                            </small>
                        </div>
                        <div class="col-12 form-group mg-t-8">
                            <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">
                                Assigner
                            </button>
                            <button type="reset" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Réinitialiser
                            </button>
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
