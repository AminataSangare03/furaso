@extends('layouts.dashboard')
@section('title', 'Tableau de bord pharmacien')

@section('content')
<h1>Tableau de bord</h1>
<p class="page-sub">Vue d'ensemble de l'activité de la pharmacie.</p>

<div class="stats">
    <div class="stat"><div class="ico"><i class="fa-solid fa-pills"></i></div><div class="label">Médicaments</div><div class="value">{{ $nbMedicaments }}</div></div>
    <div class="stat red"><div class="ico"><i data-lucide="alert-triangle"></i></div><div class="label">Stock faible</div><div class="value">{{ $nbStockFaible }}</div></div>
    <div class="stat yellow"><div class="ico"><i data-lucide="file-text"></i></div><div class="label">Ordonnances en attente</div><div class="value">{{ $nbOrdonnancesAttente }}</div></div>
    <div class="stat blue"><div class="ico"><i data-lucide="package"></i></div><div class="label">Commandes</div><div class="value">{{ $nbCommandes }}</div></div>
</div>
<div class="stats">
    <div class="stat"><div class="ico"><i data-lucide="users"></i></div><div class="label">Patients</div><div class="value">{{ $nbPatients }}</div></div>
    <div class="stat yellow"><div class="ico"><i data-lucide="clock"></i></div><div class="label">Commandes en attente</div><div class="value">{{ $nbCommandesAttente }}</div></div>
    <div class="stat blue" style="grid-column:span 2"><div class="ico"><i class="fa-solid fa-sack-dollar"></i></div><div class="label">Chiffre d'affaires</div><div class="value">{{ number_format($chiffreAffaires,0,',',' ') }} FCFA</div></div>
</div>

<div class="grid grid-2">
    <div class="card card-pad">
        <h3 class="mb">Produits les plus commandés</h3>
        @forelse($produitsPopulaires as $p)
            <div class="flex between center" style="padding:8px 0;border-bottom:1px solid var(--gris-clair)">
                <span>{{ $p->nom_medicament }}</span><span class="pill pill-green">{{ $p->total }} vendus</span>
            </div>
        @empty
            <p class="muted">Aucune vente pour l'instant.</p>
        @endforelse
    </div>
    <div class="card card-pad">
        <div class="flex between center mb"><h3>Ordonnances récentes</h3><a href="{{ route('pharmacien.ordonnances.index') }}" class="muted">Voir tout</a></div>
        @forelse($dernieresOrdonnances as $ord)
            <div class="flex between center" style="padding:8px 0;border-bottom:1px solid var(--gris-clair)">
                <span>#{{ $ord->id }} · {{ $ord->patient->user->nom_complet ?? '—' }}</span>
                <a href="{{ route('pharmacien.ordonnances.show',$ord) }}" class="pill {{ $ord->statut==='validee'?'pill-green':($ord->statut==='refusee'?'pill-red':'pill-yellow') }}">{{ $ord->statutLibelle() }}</a>
            </div>
        @empty
            <p class="muted">Aucune ordonnance.</p>
        @endforelse
    </div>
</div>

<div class="card card-pad mt">
    <div class="flex between center mb"><h3>Dernières commandes</h3><a href="{{ route('pharmacien.commandes.index') }}" class="muted">Voir tout</a></div>
    <table class="data">
        <thead><tr><th>#</th><th>Patient</th><th>Total</th><th>Statut</th><th></th></tr></thead>
        <tbody>
            @forelse($dernieresCommandes as $cmd)
                <tr>
                    <td>#{{ $cmd->id }}</td>
                    <td>{{ $cmd->patient->user->nom_complet ?? '—' }}</td>
                    <td>{{ number_format($cmd->montant_total,0,',',' ') }} FCFA</td>
                    <td><span class="pill pill-yellow">{{ $cmd->statutLibelle() }}</span></td>
                    <td><a href="{{ route('pharmacien.commandes.show',$cmd) }}" class="btn btn-outline btn-sm">Voir</a></td>
                </tr>
            @empty
                <tr><td colspan="5" class="muted">Aucune commande.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
