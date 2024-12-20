@extends('layouts.main')

@section('content')
    <div class="dashboard-content-one">
        <!-- Breadcubs Area Start Here -->
        <div class="breadcrumbs-area">
            <h3>Utilisateur</h3>
            <ul>
                <li>
                    <a href="{{url('/')}}">Accueil</a>
                </li>
                <li>{{ isset($user) ? 'Modifier' : 'Nouveau' }} Utilisateur</li>
            </ul>
        </div>
        <!-- Breadcubs Area End Here -->
        <!-- Add New Teacher Area Start Here -->
        <div class="card height-auto">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>{{ isset($user) ? 'Modifier' : 'Ajouter' }} Utilisateur</h3>
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
                      action="{{ isset($user) ? route('users.update', $user) : route('users.store') }}"
                      enctype="multipart/form-data" class="new-added-form">
                    @csrf
                    @if(isset($user))
                        @method('PUT')
                    @endif
                    <div class="row">
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Nom *</label>
                            <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}"
                                   class="form-control" required>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Post Nom *</label>
                            <input type="text" name="last_name" value="{{ old('last_name', $user->last_name ?? '') }}"
                                   class="form-control" required>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Prénom*</label>
                            <input type="text" name="first_name"
                                   value="{{ old('first_name', $user->first_name ?? '') }}" class="form-control"
                                   required>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Genre *</label>
                            <label>
                                <select class="select2" name="gender" required>
                                    <option
                                        value="male" {{ old('gender', $user->gender ?? '') === 'male' ? 'selected' : '' }}>
                                        Homme
                                    </option>
                                    <option
                                        value="female" {{ old('gender', $user->gender ?? '') === 'female' ? 'selected' : '' }}>
                                        Femme
                                    </option>
                                </select>
                            </label>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}"
                                   class="form-control" required>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Role *</label>
                            <select class="select2" name="role_id" required>
                                @foreach($roles as $role)
                                    <option
                                        value="{{ $role->id }}" {{ old('role_id', $user->role_id ?? '') == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Adresse *</label>
                            <input type="text" name="adress" value="{{ old('adress', $user->adress ?? '') }}"
                                   class="form-control" required>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Téléphone</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone ?? '') }}"
                                   class="form-control">
                        </div>
                        @if(!isset($user))
                            <div class="col-lg-6 col-12 form-group mg-t-30">
                                <label class="text-dark-medium">Mot de passe</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>

                            <div class="col-lg-6 col-12 form-group mg-t-30">
                                <label class="text-dark-medium">Confirmer le mot de passe</label>
                                <input type="password" class="form-control" id="password_confirmation"
                                       name="password_confirmation" required>
                            </div>
                        @endif
                        <div class="col-lg-6 col-12 form-group mg-t-30">
                            <label class="text-dark-medium">Avatar</label>
                            <input type="file" name="avatar" class="form-control-file">
                        </div>

                        <div class="col-lg-6 col-12 form-group mg-t-30">
                            <label>Ecole *</label>
                            <select class="select2" name="school_id" required>
                                @foreach($schools as $school)
                                    <option
                                        value="{{ $school->id }}" {{ old('school_id', $user->school_id ?? '') == $school->id ? 'selected' : '' }}>
                                        {{ $school->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 form-group mg-t-8">
                            <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">
                                {{ isset($user) ? 'Modifier' : 'Ajouter' }}
                            </button>
                            <button type="reset" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
