@extends('layouts.main')
@section('title', isset($student) ? 'Modifier un élève' : 'Ajouter un élève')

@section('meta_description')
    {{ isset($student) ? "Modification des informations de l'élève {$student->user->name}" : "Formulaire d'ajout d'un nouvel élève" }}
@endsection

@section('content')
    <div class="dashboard-content-one">
        <!-- Breadcubs Area Start Here -->
        <div class="breadcrumbs-area">
            <h3>Élève</h3>
            <ul>
                <li>
                    <a href="{{url('/')}}">Accueil</a>
                </li>
                <li>{{ isset($student) ? 'Modifier' : 'Nouvel' }} Élève</li>
            </ul>
        </div>
        <!-- Breadcubs Area End Here -->
        <!-- Add New Student Area Start Here -->
        <div class="card height-auto">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>{{ isset($student) ? 'Modifier' : 'Ajouter' }} Élève</h3>
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
                      action="{{ isset($student) ? route('students.update', $student) : route('students.store') }}"
                      class="new-added-form">
                    @csrf
                    @if(isset($student))
                        @method('PUT')
                    @endif
                    <div class="row">
                        <div class="col-xl-4 col-lg-6 col-12 form-group">
                            <label>Élève *</label>
                            <select name="user_id" class="select2" required>
                                <option value="">Sélectionner un élève</option>
                                @forelse($availableStudentUsers as $user)
                                    <option value="{{ $user->id }}"
                                        {{ old('user_id', $student->user_id ?? '') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} {{ $user->first_name }} - {{ $user->email }}
                                    </option>
                                @empty
                                    <option value="" disabled>Aucun élève disponible</option>
                                @endforelse
                            </select>
                            @error('user_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-xl-4 col-lg-6 col-12 form-group">
                            <label>Classe *</label>
                            <select name="class_id" class="select2" required id="class-select">
                                <option value="">Sélectionner une classe</option>
                                @forelse($classes as $class)
                                    <option value="{{ $class->id }}"
                                        {{ old('class_id', $student->class_id ?? '') == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                @empty
                                    <option value="" disabled>Aucune classe disponible</option>
                                @endforelse
                            </select>
                            @error('class_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-xl-4 col-lg-6 col-12 form-group">
                            <label>Option</label>
                            <select name="option_id" class="select2" id="option-select">
                                <option value="">Sélectionner une option</option>
                                @forelse($options as $option)
                                    <option value="{{ $option->id }}"
                                        {{ old('option_id', $student->option_id ?? '') == $option->id ? 'selected' : '' }}>
                                        {{ $option->name }}
                                    </option>
                                @empty
                                    <option value="" disabled>Aucune option disponible</option>
                                @endforelse
                            </select>
                            @error('option_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-xl-4 col-lg-6 col-12 form-group">
                            <label>Promotion *</label>
                            <select name="promotion_id" class="select2" required id="promotion-select">
                                <option value="">Sélectionner une promotion</option>
                                @forelse($promotions as $promotion)
                                    <option value="{{ $promotion->id }}"
                                        {{ old('promotion_id', $student->promotion_id ?? '') == $promotion->id ? 'selected' : '' }}>
                                        {{ $promotion->name }}
                                    </option>
                                @empty
                                    <option value="" disabled>Aucune promotion disponible</option>
                                @endforelse
                            </select>
                            @error('promotion_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12 form-group">
                            <label>Notes</label>
                            <textarea name="notes" class="form-control" rows="3">{{ old('notes', $student->notes ?? '') }}</textarea>
                            @error('notes')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12 form-group mg-t-8">
                            <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">
                                {{ isset($student) ? 'Modifier' : 'Ajouter' }}
                            </button>
                            <button type="reset" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const schoolSelect = document.getElementById('school-select');
                const classSelect = document.getElementById('class-select');
                const optionSelect = document.getElementById('option-select');
                const promotionSelect = document.getElementById('promotion-select');

                function updateSelects(schoolId) {
                    if (!schoolId) return;

                    // Charger les classes
                    fetch(`/api/schools/${schoolId}/classes`)
                        .then(response => response.json())
                        .then(data => {
                            classSelect.innerHTML = '<option value="">Sélectionner une classe</option>';
                            data.forEach(classe => {
                                classSelect.innerHTML += `<option value="${classe.id}">${classe.name}</option>`;
                            });
                            @if(isset($student))
                                classSelect.value = "{{ $student->class_id }}";
                            @endif
                        });

                    // Charger les options
                    fetch(`/api/schools/${schoolId}/options`)
                        .then(response => response.json())
                        .then(data => {
                            optionSelect.innerHTML = '<option value="">Sélectionner une option</option>';
                            data.forEach(option => {
                                optionSelect.innerHTML += `<option value="${option.id}">${option.name}</option>`;
                            });
                            @if(isset($student))
                                optionSelect.value = "{{ $student->option_id }}";
                            @endif
                        });

                    // Charger les promotions
                    fetch(`/api/schools/${schoolId}/promotions`)
                        .then(response => response.json())
                        .then(data => {
                            promotionSelect.innerHTML = '<option value="">Sélectionner une promotion</option>';
                            data.forEach(promotion => {
                                promotionSelect.innerHTML += `<option value="${promotion.id}">${promotion.name}</option>`;
                            });
                            @if(isset($student))
                                promotionSelect.value = "{{ $student->promotion_id }}";
                            @endif
                        });
                }

                schoolSelect.addEventListener('change', function() {
                    updateSelects(this.value);
                });

                // Charger les données initiales si on est en mode édition
                if (schoolSelect.value) {
                    updateSelects(schoolSelect.value);
                }
            });
        </script>
    @endpush
@endsection
