@extends('layouts.app')
@section('title', 'Inscription — Furaso')

@section('content')
<div class="auth-wrap">
    <div class="card card-pad auth-card wide">
        <h2 class="text-center mb">Créer un compte patient</h2>
        <p class="text-center muted mb">Rejoignez Furaso et commandez vos médicaments en toute simplicité</p>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="row-2">
                <div class="form-group"><label>Nom</label><input type="text" name="name" value="{{ old('name') }}" required></div>
                <div class="form-group"><label>Prénom</label><input type="text" name="prenom" value="{{ old('prenom') }}" required></div>
            </div>
            <div class="row-2">
                <div class="form-group"><label>Sexe</label><select name="sexe"><option value="">—</option><option value="M" @selected(old('sexe')==='M')>Masculin</option><option value="F" @selected(old('sexe')==='F')>Féminin</option></select></div>
                <div class="form-group"><label>Date de naissance</label><input type="date" name="date_naissance" value="{{ old('date_naissance') }}"></div>
            </div>
            <div class="row-2">
                <div class="form-group"><label>Téléphone</label><input type="text" name="telephone" value="{{ old('telephone') }}" required></div>
                <div class="form-group"><label>Email</label><input type="email" name="email" value="{{ old('email') }}" required></div>
            </div>
            <div class="row-2">
                <div class="form-group"><label>Mot de passe</label><input type="password" name="password" required></div>
                <div class="form-group"><label>Confirmer le mot de passe</label><input type="password" name="password_confirmation" required></div>
            </div>
            <hr style="border:none;border-top:1px solid var(--gris-clair);margin:8px 0 18px">
            <div class="row-2">
                <div class="form-group"><label>Adresse</label><input type="text" name="adresse" value="{{ old('adresse') }}"></div>
                <div class="form-group"><label>Quartier</label><input type="text" name="quartier" value="{{ old('quartier') }}"></div>
            </div>
            <div class="row-2">
                <div class="form-group"><label>Ville</label><input type="text" name="ville" value="{{ old('ville') }}"></div>
                <div class="form-group"><label>Région</label><input type="text" name="region" value="{{ old('region') }}"></div>
            </div>
            <div class="row-2">
                <div class="form-group"><label>Personne à contacter (urgence)</label><input type="text" name="personne_urgence" value="{{ old('personne_urgence') }}"></div>
                <div class="form-group"><label>Téléphone d'urgence</label><input type="text" name="telephone_urgence" value="{{ old('telephone_urgence') }}"></div>
            </div>
            <button class="btn btn-primary btn-block" type="submit">Créer mon compte</button>
        </form>
        <p class="text-center mt">Déjà inscrit ? <a href="{{ route('login') }}">Connectez-vous</a></p>
    </div>
</div>
@endsection
