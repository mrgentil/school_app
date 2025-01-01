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

            <form method="POST" action="{{ route('student-promotions.promote') }}" id="promotionForm">
                @csrf

                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Classe cible <span class="text-danger">*</span></label>
                            <select name="target_class_id" class="form-control" required>
                                <option value="">Sélectionner une classe</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Année académique <span class="text-danger">*</span></label>
                            <input type="text" name="academic_year" class="form-control"
                                   placeholder="Ex: 2023-2024" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Type de promotion <span class="text-danger">*</span></label>
                            <select name="promotion_type" class="form-control" required>
                                <option value="automatic">Automatique (basé sur les résultats)</option>
                                <option value="manual">Manuelle (sélection libre)</option>
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
                                    </div>
                                </th>
                                <th>Élève</th>
                                <th>Classe actuelle</th>
                                <th>Moyenne</th>
                                <th>Décision</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input type="checkbox" name="students[]"
                                                   value="{{ $student->id }}"
                                                   class="form-check-input">
                                        </div>
                                    </td>
                                    <td>{{ $student->user->name }}</td>
                                    <td>{{ $student->class->name }}</td>
                                    <td>
                                        {{ $student->histories->first()?->average_score ?? '-' }}/20
                                    </td>
                                    <td>
                                        @if($student->histories->first())
                                            <span class="badge {{ $student->histories->first()->decision === 'Admis' ? 'badge-success' : 'badge-warning' }}">
                                                {{ $student->histories->first()->decision }}
                                            </span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if($student->histories->first()?->average_score >= 10)
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
    // Gestion de la case à cocher "Tout sélectionner"
    $('.checkAll').on('change', function() {
        $('input[name="students[]"]').prop('checked', $(this).is(':checked'));
    });

    // Gestion du type de promotion
    $('select[name="promotion_type"]').on('change', function() {
        if ($(this).val() === 'automatic') {
            // Désélectionner les élèves non éligibles
            $('tr').each(function() {
                if ($(this).find('.badge-danger').length) {
                    $(this).find('input[type="checkbox"]').prop('checked', false);
                }
            });
        }
    });

    // Validation du formulaire
    $('#promotionForm').on('submit', function(e) {
        if (!$('input[name="students[]"]:checked').length) {
            e.preventDefault();
            alert('Veuillez sélectionner au moins un élève');
        }
    });
});
</script>
@endpush
