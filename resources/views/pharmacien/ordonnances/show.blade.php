@extends('layouts.dashboard')
@section('title', 'Ordonnance #'.$ordonnance->id)

@section('content')
<a href="{{ route('pharmacien.ordonnances.index') }}" class="muted">← Retour</a>
<h1 class="mt">Ordonnance #{{ $ordonnance->id }}</h1>
<p class="page-sub">Patient : {{ $ordonnance->patient->user->nom_complet ?? '—' }}</p>

<div class="grid grid-2">
    <div class="card card-pad">
        <h3 class="mb">Document</h3>
        @if($ordonnance->type === 'pdf')
            <a href="{{ asset('storage/'.$ordonnance->fichier) }}" target="_blank" class="btn btn-secondary">📄 Ouvrir le PDF</a>
        @else
            <img src="{{ asset('storage/'.$ordonnance->fichier) }}" alt="Ordonnance" style="border-radius:9px;border:1px solid var(--gris-clair)">
        @endif
    </div>

    <div class="card card-pad" style="align-self:start">
        <h3 class="mb">Décision</h3>
        <p class="mb">Statut actuel : <span class="pill {{ $ordonnance->statut==='validee'?'pill-green':($ordonnance->statut==='refusee'?'pill-red':'pill-yellow') }}">{{ $ordonnance->statutLibelle() }}</span></p>
        <form method="POST" action="{{ route('pharmacien.ordonnances.valider', $ordonnance) }}">
            @csrf @method('PUT')
            <div class="form-group">
                <label>Décision</label>
                <select name="statut" required>
                    <option value="validee" @selected($ordonnance->statut==='validee')>Valider</option>
                    <option value="refusee" @selected($ordonnance->statut==='refusee')>Refuser</option>
                </select>
            </div>
            <div class="form-group">
                <label>Commentaire (optionnel)</label>
                <textarea name="commentaire_pharmacien" rows="4">{{ $ordonnance->commentaire_pharmacien }}</textarea>
            </div>
            <button class="btn btn-primary" type="submit">Enregistrer la décision</button>
        </form>
    </div>
</div>
@endsection
