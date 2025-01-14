@extends('layouts.main')
@section('title', isset($school) ? 'Modifier une école' : 'Ajouter une école')
@section('meta_description')
    {{ isset($school) ? "Modification des informations de l'école {$school->name}" : "Formulaire d'ajout d'une nouvelle école" }}
@endsection
@section('content')
    <div class="dashboard-content-one">
        <!-- Breadcubs Area Start Here -->
        <div class="breadcrumbs-area">
            <h3>Utilisateur</h3>
            <ul>
                <li>
                    <a href="{{url('/')}}">Accueil</a>
                </li>
                <li>{{ isset($school) ? 'Modifier' : 'Nouveau' }} Ecole</li>
            </ul>
        </div>
        <!-- Breadcubs Area End Here -->
        <!-- Add New Teacher Area Start Here -->
        <div class="card height-auto">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>{{ isset($school) ? 'Modifier' : 'Ajouter' }} Ecole</h3>
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
                      action="{{ isset($school) ? route('schools.update', $school) : route('schools.store') }}"
                      enctype="multipart/form-data" class="new-added-form">
                    @csrf
                    @if(isset($school))
                        @method('PUT')
                    @endif
                    <div class="row">
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Nom *</label>
                            <input type="text" name="name" value="{{ old('name', $school->name ?? '') }}"
                                   class="form-control" required>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Adresse *</label>
                            <input type="text" name="adress" value="{{ old('adress', $school->adress ?? '') }}"
                                   class="form-control" required>
                        </div>

                        <div class="col-lg-6 col-12 form-group mg-t-30">
                            <label class="text-dark-medium">Logo</label>
                            <input type="file" name="logo" class="form-control-file">
                            @if(isset($school) && $school->logo)
                                <p>Logo actuel : <img src="{{ asset('storage/' . $school->logo) }}"
                                                      alt="{{ $school->name }}" style="max-width: 100px;"></p>
                            @endif
                        </div>
                        <div class="col-12 form-group mg-t-8">
                            <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">
                                {{ isset($school) ? 'Modifier' : 'Ajouter' }}
                            </button>
                            <button type="reset" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
