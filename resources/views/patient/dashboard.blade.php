@extends('layouts.dashboard')
@section('title', 'Mon espace')

@section('content')
<h1>Bonjour {{ $user->prenom }} 👋</h1>
<p class="page-sub">Bienvenue dans votre espace Furaso.</p>

<div class="stats">
    <div class="stat"><div class="ico">📦</div><div class="label">Commandes</div><div class="value">{{ $nbCommandes }}</div></div>
    <div class="stat blue"><div class="ico">📄</div><div class="label">Ordonnances</div><div class="value">{{ $nbOrdonnances }}</div></div>
    <div class="stat yellow"><div class="ico">⭐</div><div class="label">Favoris</div><div class="value">{{ $nbFavoris }}</div></div>
    <div class="stat"><div class="ico">🔔</div><div class="label">Notifications</div><div class="value">{{ $notifications->count() }}</div></div>
</div>

<div class="grid grid-2">
    <div class="card card-pad">
        <div class="flex between center mb"><h3>Dernières commandes</h3><a href="{{ route('patient.commandes.index') }}" class="muted">Voir tout</a></div>
        @forelse($commandes as $cmd)
            <div class="flex between center" style="padding:8px 0;border-bottom:1px solid var(--gris-clair)">
                <div><strong>Commande #{{ $cmd->id }}</strong><br><span class="muted">{{ $cmd->created_at->format('d/m/Y') }} · {{ number_format($cmd->montant_total,0,',',' ') }} FCFA</span></div>
                <a href="{{ route('patient.commandes.show', $cmd) }}" class="pill pill-blue">{{ $cmd->statutLibelle() }}</a>
            </div>
        @empty
            <p class="muted">Aucune commande pour l'instant. <a href="{{ route('catalogue.index') }}">Commander</a></p>
        @endforelse
    </div>

    <div class="card card-pad">
        <div class="flex between center mb"><h3>Ordonnances récentes</h3><a href="{{ route('patient.ordonnances.index') }}" class="muted">Voir tout</a></div>
        @forelse($ordonnances as $ord)
            <div class="flex between center" style="padding:8px 0;border-bottom:1px solid var(--gris-clair)">
                <div><strong>Ordonnance #{{ $ord->id }}</strong><br><span class="muted">{{ $ord->created_at->format('d/m/Y') }}</span></div>
                <span class="pill {{ $ord->statut==='validee'?'pill-green':($ord->statut==='refusee'?'pill-red':'pill-yellow') }}">{{ $ord->statutLibelle() }}</span>
            </div>
        @empty
            <p class="muted">Aucune ordonnance. <a href="{{ route('patient.ordonnances.create') }}">En envoyer une</a></p>
        @endforelse
    </div>
</div>

<div class="card card-pad mt">
    <div class="flex between center mb"><h3>Notifications</h3><a href="{{ route('notifications.index') }}" class="muted">Voir tout</a></div>
    @forelse($notifications as $notif)
        <div style="padding:8px 0;border-bottom:1px solid var(--gris-clair)">
            <strong>{{ $notif->titre }}</strong> @if(! $notif->lu)<span class="pill pill-green">Nouveau</span>@endif
            <br><span class="muted">{{ $notif->contenu }}</span>
        </div>
    @empty
        <p class="muted">Aucune notification.</p>
    @endforelse
</div>
@endsection
