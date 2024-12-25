@extends('layouts.main')
@section('title', isset($class) ? 'Modifier une classe' : 'Ajouter une classe')
@section('meta_description')
    {{ isset($class) ? "Modification des informations de la classe {$class->name}" : "Formulaire d'ajout d'une nouvelle classe" }}
@endsection
@section('content')
    <div class="dashboard-content-one">
        <!-- Breadcubs Area Start Here -->
        <div class="breadcrumbs-area">
            <h3>Classe</h3>
            <ul>
                <li>
                    <a href="{{url('/')}}">Accueil</a>
                </li>
                <li>{{ isset($class) ? 'Modifier' : 'Nouvelle' }} Classe</li>
            </ul>
        </div>
        <!-- Breadcubs Area End Here -->
        <!-- Add New Teacher Area Start Here -->
        <div class="card height-auto">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>{{ isset($class) ? 'Modifier' : 'Ajouter' }} Classe</h3>
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
                      action="{{ isset($class) ? route('classes.update', $class) : route('classes.store') }}"
                      enctype="multipart/form-data" class="new-added-form">
                    @csrf
                    @if(isset($class))
                        @method('PUT')
                    @endif
                    <div class="row">
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Nom *</label>
                            <input type="text" name="name" value="{{ old('name', $class->name ?? '') }}"
                                   class="form-control" required>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Ecole *</label>
                            <select class="select2" name="school_id" required>
                                @foreach($schools as $school)
                                    <option
                                        value="{{ $school->id }}" {{ old('school_id', $class->school_id ?? '') == $school->id ? 'selected' : '' }}>
                                        {{ $school->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 form-group mg-t-8">
                            <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">
                                {{ isset($class) ? 'Modifier' : 'Ajouter' }}
                            </button>
                            <button type="reset" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
