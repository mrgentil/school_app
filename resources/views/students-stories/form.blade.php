@extends('layouts.main')
@section('title', isset($history) ? "Modifier l'historique" : "Ajouter un historique")

@section('content')
    <div class="dashboard-content-one">
        <div class="breadcrumbs-area">
            <h3>{{ isset($history) ? "Modifier l'historique" : "Ajouter un historique" }}</h3>
            <ul>
                <li><a href="{{ url('/') }}">Accueil</a></li>
                <li><a href="{{ route('histories.index') }}">Historiques</a></li>
                <li>{{ isset($history) ? "Modifier" : "Ajouter" }}</li>
            </ul>
        </div>

        <div class="card height-auto">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>{{ isset($history) ? "Modifier l'historique" : "Nouvel historique" }}</h3>
                    </div>
                </div>

                <form method="POST" action="{{ isset($history) ? route('histories.update', $history) : route('histories.store') }}">
                    @csrf
                    @if(isset($history))
                        @method('PUT')
                    @endif

                    @if(!isset($history))
                        <div class="row mb-4">
                            <div class="col-md-6 form-group">
                                <label>Élève <span class="text-danger">*</span></label>
                                <select name="student_id" class="form-control select2" required>
                                    <option value="">Sélectionner un élève</option>
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                            {{ $student->user->name }} ({{ $student->registration_number }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('student_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @else
                        <input type="hidden" name="student_id" value="{{ $history->student_id }}">
                    @endif

                    <div class="row">
                        <!-- Informations académiques -->
                        <div class="col-12">
                            <h5 class="mb-3">Informations académiques</h5>
                        </div>

                        <div class="col-md-3 form-group">
                            <label>Année académique <span class="text-danger">*</span></label>
                            <input type="text" name="academic_year" class="form-control"
                                   placeholder="Ex: 2023-2024"
                                   value="{{ old('academic_year', $history->academic_year ?? '') }}" required>
                            @error('academic_year')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-3 form-group">
                            <label>Semestre <span class="text-danger">*</span></label>
                            <select name="semester" class="form-control" required>
                                <option value="">Sélectionner</option>
                                <option value="Semestre 1" {{ old('semester', $history->semester ?? '') == 'Semestre 1' ? 'selected' : '' }}>
                                    Semestre 1
                                </option>
                                <option value="Semestre 2" {{ old('semester', $history->semester ?? '') == 'Semestre 2' ? 'selected' : '' }}>
                                    Semestre 2
                                </option>
                            </select>
                            @error('semester')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-3 form-group">
                            <label>Classe <span class="text-danger">*</span></label>
                            <select name="class_id" class="form-control" required>
                                <option value="">Sélectionner</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}"
                                        {{ old('class_id', $history->class_id ?? '') == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('class_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-3 form-group">
                            <label>Option</label>
                            <select name="option_id" class="form-control">
                                <option value="">Sélectionner</option>
                                @foreach($options as $option)
                                    <option value="{{ $option->id }}"
                                        {{ old('option_id', $history->option_id ?? '') == $option->id ? 'selected' : '' }}>
                                        {{ $option->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('option_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Résultats -->
                        <div class="col-12 mt-4">
                            <h5 class="mb-3">Résultats</h5>
                        </div>

                        <div class="col-md-4 form-group">
                            <label>Moyenne</label>
                            <input type="number" name="average_score" class="form-control"
                                   step="0.01" min="0" max="20"
                                   placeholder="Ex: 15.50"
                                   value="{{ old('average_score', $history->average_score ?? '') }}">
                            @error('average_score')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4 form-group">
                            <label>Rang</label>
                            <input type="number" name="rank" class="form-control"
                                   min="1"
                                   placeholder="Ex: 1"
                                   value="{{ old('rank', $history->rank ?? '') }}">
                            @error('rank')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4 form-group">
                            <label>Décision</label>
                            <select name="decision" class="form-control">
                                <option value="En cours" {{ old('decision', $history->decision ?? '') == 'En cours' ? 'selected' : '' }}>
                                    En cours
                                </option>
                                <option value="Admis" {{ old('decision', $history->decision ?? '') == 'Admis' ? 'selected' : '' }}>
                                    Admis
                                </option>
                                <option value="Ajourné" {{ old('decision', $history->decision ?? '') == 'Ajourné' ? 'selected' : '' }}>
                                    Ajourné
                                </option>
                                <option value="Redouble" {{ old('decision', $history->decision ?? '') == 'Redouble' ? 'selected' : '' }}>
                                    Redouble
                                </option>
                            </select>
                            @error('decision')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Comportement et remarques -->
                        <div class="col-12 mt-4">
                            <h5 class="mb-3">Comportement et remarques</h5>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Note de conduite</label>
                            <select name="conduct_grade" class="form-control">
                                <option value="">Sélectionner</option>
                                <option value="Excellent" {{ old('conduct_grade', $history->conduct_grade ?? '') == 'Excellent' ? 'selected' : '' }}>
                                    Excellent
                                </option>
                                <option value="Très Bien" {{ old('conduct_grade', $history->conduct_grade ?? '') == 'Très Bien' ? 'selected' : '' }}>
                                    Très Bien
                                </option>
                                <option value="Bien" {{ old('conduct_grade', $history->conduct_grade ?? '') == 'Bien' ? 'selected' : '' }}>
                                    Bien
                                </option>
                                <option value="Assez Bien" {{ old('conduct_grade', $history->conduct_grade ?? '') == 'Assez Bien' ? 'selected' : '' }}>
                                    Assez Bien
                                </option>
                                <option value="Passable" {{ old('conduct_grade', $history->conduct_grade ?? '') == 'Passable' ? 'selected' : '' }}>
                                    Passable
                                </option>
                                <option value="Insuffisant" {{ old('conduct_grade', $history->conduct_grade ?? '') == 'Insuffisant' ? 'selected' : '' }}>
                                    Insuffisant
                                </option>
                            </select>
                            @error('conduct_grade')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Assiduité</label>
                            <textarea name="attendance_record" class="form-control" rows="2"
                                      placeholder="Absences, retards...">{{ old('attendance_record', $history->attendance_record ?? '') }}</textarea>
                            @error('attendance_record')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12 form-group">
                            <label>Remarques des enseignants</label>
                            <textarea name="teacher_remarks" class="form-control" rows="3"
                                      placeholder="Observations, recommandations...">{{ old('teacher_remarks', $history->teacher_remarks ?? '') }}</textarea>
                            @error('teacher_remarks')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Boutons -->
                        <div class="col-12 form-group mg-t-8">
                            <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">
                                {{ isset($history) ? 'Modifier' : 'Enregistrer' }}
                            </button>
                            <a href="{{ route('histories.index') }}" class="btn-fill-lg bg-blue-dark btn-hover-yellow">
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
                width: '100%',
                placeholder: 'Sélectionner un élève'
            });
        });
    </script>
@endpush
