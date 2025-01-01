@extends('layouts.main')
@section('title', 'Promotion des élèves')

@section('content')
    <div class="dashboard-content-one">
        <div class="breadcrumbs-area">
            <h3>Promotion des élèves</h3>
            <ul>
                <li><a href="{{ url('/') }}">Accueil</a></li>
                <li>Promotion des élèves</li>
            </ul>
        </div>

        <div class="card height-auto">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>Gérer les promotions</h3>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('student-promotions.promote') }}" id="promotionForm">
                    @csrf

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Nom de la promotion <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control"
                                       value="{{ old('name') }}"
                                       placeholder="Ex: Promotion 2024" required>
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Classe cible <span class="text-danger">*</span></label>
                                <select name="target_class_id" class="form-control select2" required>
                                    <option value="">Sélectionner une classe</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}"
                                            {{ old('target_class_id') == $class->id ? 'selected' : '' }}>
                                            {{ $class->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('target_class_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Année académique <span class="text-danger">*</span></label>
                                <input type="text" name="academic_year" class="form-control"
                                       value="{{ old('academic_year') }}"
                                       placeholder="Ex: 2023-2024" required>
                                @error('academic_year')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Type de promotion <span class="text-danger">*</span></label>
                                <select name="promotion_type" class="form-control" required>
                                    <option value="automatic" {{ old('promotion_type') == 'automatic' ? 'selected' : '' }}>
                                        Automatique (basé sur les résultats)
                                    </option>
                                    <option value="manual" {{ old('promotion_type') == 'manual' ? 'selected' : '' }}>
                                        Manuelle (sélection libre)
                                    </option>
                                </select>
                                @error('promotion_type')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Filtrer par classe actuelle</label>
                                <select id="filter_class" class="form-control select2">
                                    <option value="">Toutes les classes</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table display data-table text-nowrap">
                            <thead>
                            <tr>
                                <th>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input checkAll">
                                        <label class="form-check-label">Tout</label>
                                    </div>
                                </th>
                                <th>Matricule</th>
                                <th>Élève</th>
                                <th>Classe actuelle</th>
                                <th>Moyenne</th>
                                <th>Décision</th>
                                <th>Statut</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($students as $student)
                                @php
                                    $currentHistory = $student->histories->first();
                                    $isEligible = $currentHistory &&
                                                $currentHistory->average_score >= 10 &&
                                                $currentHistory->decision === 'Admis';
                                @endphp
                                <tr data-class="{{ $student->class_id }}"
                                    class="{{ $isEligible ? 'table-success' : '' }}">
                                    <td>
                                        <div class="form-check">
                                            <input type="checkbox"
                                                   name="students[]"
                                                   value="{{ $student->id }}"
                                                   class="form-check-input student-checkbox"
                                                {{ old('students') && in_array($student->id, old('students')) ? 'checked' : '' }}
                                                {{ !$isEligible ? 'data-not-eligible' : '' }}>
                                        </div>
                                    </td>
                                    <td>{{ $student->registration_number }}</td>
                                    <td>{{ $student->user->name }}</td>
                                    <td>{{ $student->class->name }}</td>
                                    <td>
                                        {{ $currentHistory ? number_format($currentHistory->average_score, 2) . '/20' : '-' }}
                                    </td>
                                    <td>
                                        @if($currentHistory)
                                            <span class="badge {{ $currentHistory->decision === 'Admis' ? 'badge-success' : 'badge-warning' }}">
                                                {{ $currentHistory->decision }}
                                            </span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if($isEligible)
                                            <span class="badge badge-success">Éligible</span>
                                        @else
                                            <span class="badge badge-danger">Non éligible</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">
                                Promouvoir les élèves sélectionnés
                            </button>
                            <a href="{{ route('student-promotions.index') }}"
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

@push('styles')
    <style>
        .table tr.table-success {
            background-color: rgba(40, 167, 69, 0.1);
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialisation de Select2
            $('.select2').select2({
                width: '100%'
            });

            // Gestion de la case à cocher "Tout sélectionner"
            $('.checkAll').on('change', function() {
                let isChecked = $(this).is(':checked');
                let checkboxes = $('.student-checkbox');

                if ($('select[name="promotion_type"]').val() === 'automatic') {
                    checkboxes = checkboxes.not('[data-not-eligible]');
                }

                checkboxes.prop('checked', isChecked);
            });

            // Gestion du type de promotion
            $('select[name="promotion_type"]').on('change', function() {
                if ($(this).val() === 'automatic') {
                    $('.student-checkbox[data-not-eligible]').prop('checked', false);
                }
            });

            // Filtre par classe
            $('#filter_class').on('change', function() {
                let selectedClass = $(this).val();

                if (selectedClass) {
                    $('tr[data-class]').hide();
                    $('tr[data-class="' + selectedClass + '"]').show();
                } else {
                    $('tr[data-class]').show();
                }
            });

            // Validation du formulaire
            $('#promotionForm').on('submit', function(e) {
                let checkedStudents = $('input[name="students[]"]:checked').length;

                if (checkedStudents === 0) {
                    e.preventDefault();
                    alert('Veuillez sélectionner au moins un élève');
                    return false;
                }

                return confirm('Êtes-vous sûr de vouloir promouvoir les ' + checkedStudents + ' élève(s) sélectionné(s) ?');
            });
        });
    </script>
@endpush
