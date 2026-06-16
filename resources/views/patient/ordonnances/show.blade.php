@extends('layouts.dashboard')
@section('title', 'Ordonnance #'.$ordonnance->id)

@section('content')
<a href="{{ route('patient.ordonnances.index') }}" class="muted">← Retour</a>
<h1 class="mt">Ordonnance #{{ $ordonnance->id }}</h1>
<p class="page-sub">Envoyée le {{ optional($ordonnance->date_envoi)->format('d/m/Y à H:i') }}</p>

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
        <h3 class="mb">Statut</h3>
        <p class="mb"><span class="pill {{ $ordonnance->statut==='validee'?'pill-green':($ordonnance->statut==='refusee'?'pill-red':'pill-yellow') }}">{{ $ordonnance->statutLibelle() }}</span></p>
        @if($ordonnance->commentaire_pharmacien)
            <h4 class="mb">Commentaire du pharmacien</h4>
            <p class="muted">{{ $ordonnance->commentaire_pharmacien }}</p>
        @endif
        @if($ordonnance->statut === 'validee')
            <a href="{{ route('catalogue.index') }}" class="btn btn-primary mt">Commander mes médicaments</a>
        @endif
    </div>
</div>
@endsection
