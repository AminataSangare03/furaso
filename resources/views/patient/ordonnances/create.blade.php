@extends('layouts.dashboard')
@section('title', 'Envoyer une ordonnance')

@section('content')
<h1>Envoyer une ordonnance</h1>
<p class="page-sub">Prenez une photo ou téléversez un PDF de votre ordonnance.</p>

<div class="card card-pad" style="max-width:620px">
    <form method="POST" action="{{ route('patient.ordonnances.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Fichier de l'ordonnance (photo JPG/PNG ou PDF)</label>
            <input type="file" name="fichier" accept="image/*,application/pdf" required>
            <p class="help">Taille max : 8 Mo. Sur mobile, vous pouvez prendre une photo directement.</p>
        </div>
        <div class="form-group">
            <label>Pharmacie (optionnel)</label>
            <select name="pharmacie_id">
                <option value="">— Laisser Furaso choisir —</option>
                @foreach($pharmacies as $ph)
                    <option value="{{ $ph->id }}">{{ $ph->nom }} ({{ $ph->ville }})</option>
                @endforeach
            </select>
        </div>
        <button class="btn btn-primary" type="submit">Envoyer l'ordonnance</button>
        <a href="{{ route('patient.ordonnances.index') }}" class="btn btn-ghost">Annuler</a>
    </form>
</div>
@endsection
