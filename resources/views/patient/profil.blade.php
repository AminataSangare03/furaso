@extends('layouts.dashboard')
@section('title', 'Mon profil')

@section('content')
<h1>Mon profil</h1>
<p class="page-sub">Gérez vos informations personnelles.</p>

<div class="grid grid-2">
    <div class="card card-pad">
        <h3 class="mb">Informations</h3>
        <form method="POST" action="{{ route('patient.profil.update') }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="form-group text-center">
                <div style="width:90px;height:90px;border-radius:50%;background:var(--vert-clair);color:var(--vert);display:grid;place-items:center;font-size:2rem;margin:0 auto 10px;overflow:hidden">
                    @if($user->photo)<img src="{{ asset('storage/'.$user->photo) }}" style="width:100%;height:100%;object-fit:cover">@else <i data-lucide="user"></i> @endif
                </div>
                <input type="file" name="photo" accept="image/*">
            </div>
            <div class="row-2">
                <div class="form-group"><label>Nom</label><input type="text" name="name" value="{{ old('name',$user->name) }}" required></div>
                <div class="form-group"><label>Prénom</label><input type="text" name="prenom" value="{{ old('prenom',$user->prenom) }}" required></div>
            </div>
            <div class="row-2">
                <div class="form-group"><label>Email</label><input type="email" name="email" value="{{ old('email',$user->email) }}" required></div>
                <div class="form-group"><label>Téléphone</label><input type="text" name="telephone" value="{{ old('telephone',$user->telephone) }}"></div>
            </div>
            <div class="row-2">
                <div class="form-group"><label>Sexe</label><select name="sexe"><option value="">—</option><option value="M" @selected($user->sexe==='M')>Masculin</option><option value="F" @selected($user->sexe==='F')>Féminin</option></select></div>
                <div class="form-group"><label>Date de naissance</label><input type="date" name="date_naissance" value="{{ old('date_naissance', optional($user->date_naissance)->format('Y-m-d')) }}"></div>
            </div>
            <div class="row-2">
                <div class="form-group"><label>Adresse</label><input type="text" name="adresse" value="{{ old('adresse',$user->adresse) }}"></div>
                <div class="form-group"><label>Quartier</label><input type="text" name="quartier" value="{{ old('quartier',$user->quartier) }}"></div>
            </div>
            <div class="row-2">
                <div class="form-group"><label>Ville</label><input type="text" name="ville" value="{{ old('ville',$user->ville) }}"></div>
                <div class="form-group"><label>Région</label><input type="text" name="region" value="{{ old('region',$user->region) }}"></div>
            </div>
            <div class="row-2">
                <div class="form-group"><label>Personne à contacter (urgence)</label><input type="text" name="personne_urgence" value="{{ old('personne_urgence',$user->personne_urgence) }}"></div>
                <div class="form-group"><label>Téléphone d'urgence</label><input type="text" name="telephone_urgence" value="{{ old('telephone_urgence',$user->telephone_urgence) }}"></div>
            </div>
            <button class="btn btn-primary" type="submit">Enregistrer</button>
        </form>
    </div>

    <div class="card card-pad" style="align-self:start">
        <h3 class="mb">Changer le mot de passe</h3>
        <form method="POST" action="{{ route('patient.profil.password') }}">
            @csrf @method('PUT')
            <div class="form-group"><label>Mot de passe actuel</label><input type="password" name="current_password" required></div>
            <div class="form-group"><label>Nouveau mot de passe</label><input type="password" name="password" required></div>
            <div class="form-group"><label>Confirmer</label><input type="password" name="password_confirmation" required></div>
            <button class="btn btn-secondary" type="submit">Modifier</button>
        </form>
    </div>
</div>
@endsection
