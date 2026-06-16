@extends('layouts.dashboard')
@section('title', $pharmacie->exists ? 'Modifier une pharmacie' : 'Nouvelle pharmacie')

@section('content')
<a href="{{ route('admin.pharmacies.index') }}" class="muted"><i data-lucide="arrow-left"></i> Retour</a>
<h1 class="mt">{{ $pharmacie->exists ? 'Modifier la pharmacie' : 'Nouvelle pharmacie' }}</h1>

<div class="card card-pad" style="max-width:720px">
    <form method="POST" action="{{ $pharmacie->exists ? route('admin.pharmacies.update', $pharmacie) : route('admin.pharmacies.store') }}">
        @csrf
        @if($pharmacie->exists) @method('PUT') @endif
        <div class="form-group"><label>Nom *</label><input type="text" name="nom" value="{{ old('nom',$pharmacie->nom) }}" required></div>
        <div class="form-group"><label>Adresse</label><input type="text" name="adresse" value="{{ old('adresse',$pharmacie->adresse) }}"></div>
        <div class="row-2">
            <div class="form-group"><label>Téléphone</label><input type="text" name="telephone" value="{{ old('telephone',$pharmacie->telephone) }}"></div>
            <div class="form-group"><label>Email</label><input type="email" name="email" value="{{ old('email',$pharmacie->email) }}"></div>
        </div>
        <div class="row-2">
            <div class="form-group"><label>Ville</label><input type="text" name="ville" value="{{ old('ville',$pharmacie->ville) }}"></div>
            <div class="form-group"><label>Région</label><input type="text" name="region" value="{{ old('region',$pharmacie->region) }}"></div>
        </div>
        <div class="row-2">
            <div class="form-group"><label>Latitude</label><input type="text" name="latitude" value="{{ old('latitude',$pharmacie->latitude) }}"></div>
            <div class="form-group"><label>Longitude</label><input type="text" name="longitude" value="{{ old('longitude',$pharmacie->longitude) }}"></div>
        </div>
        <div class="form-group">
            <label style="font-weight:400"><input type="checkbox" name="partenaire" value="1" style="width:auto" @checked(old('partenaire', $pharmacie->exists ? $pharmacie->partenaire : true))> Pharmacie partenaire</label>
        </div>
        <button class="btn btn-primary" type="submit">Enregistrer</button>
        <a href="{{ route('admin.pharmacies.index') }}" class="btn btn-ghost">Annuler</a>
    </form>
</div>
@endsection
