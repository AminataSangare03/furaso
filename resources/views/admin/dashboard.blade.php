@extends('layouts.dashboard')
@section('title', 'Administration')

@section('content')
<h1>Tableau de bord — Administration</h1>
<p class="page-sub">Vue d'ensemble de la plateforme Furaso.</p>

<div class="stats">
    <div class="stat"><div class="ico">👥</div><div class="label">Utilisateurs</div><div class="value">{{ $nbUsers }}</div></div>
    <div class="stat blue"><div class="ico">🧑</div><div class="label">Patients</div><div class="value">{{ $nbPatients }}</div></div>
    <div class="stat"><div class="ico">👨‍⚕️</div><div class="label">Pharmaciens</div><div class="value">{{ $nbPharmaciens }}</div></div>
    <div class="stat blue"><div class="ico">🏥</div><div class="label">Pharmacies</div><div class="value">{{ $nbPharmacies }}</div></div>
</div>
<div class="stats">
    <div class="stat"><div class="ico">💊</div><div class="label">Médicaments</div><div class="value">{{ $nbMedicaments }}</div></div>
    <div class="stat yellow"><div class="ico">📦</div><div class="label">Commandes</div><div class="value">{{ $nbCommandes }}</div></div>
    <div class="stat"><div class="ico">💰</div><div class="label">Chiffre d'affaires</div><div class="value">{{ number_format($chiffreAffaires,0,',',' ') }}</div></div>
    <div class="stat blue"><div class="ico">✅</div><div class="label">Paiements encaissés</div><div class="value">{{ number_format($paiementsPayes,0,',',' ') }}</div></div>
</div>

<div class="grid grid-2">
    <div class="card card-pad">
        <div class="flex between center mb"><h3>Derniers utilisateurs</h3><a href="{{ route('admin.users.index') }}" class="muted">Gérer</a></div>
        <table class="data">
            <thead><tr><th>Nom</th><th>Rôle</th><th>Inscrit</th></tr></thead>
            <tbody>
                @foreach($derniersUsers as $u)
                    <tr><td>{{ $u->nom_complet }}</td><td><span class="pill pill-gray">{{ ucfirst($u->role) }}</span></td><td>{{ $u->created_at->format('d/m/Y') }}</td></tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card card-pad">
        <div class="flex between center mb"><h3>Dernières commandes</h3><a href="{{ route('pharmacien.commandes.index') }}" class="muted">Voir</a></div>
        <table class="data">
            <thead><tr><th>#</th><th>Patient</th><th>Total</th></tr></thead>
            <tbody>
                @foreach($dernieresCommandes as $cmd)
                    <tr><td>#{{ $cmd->id }}</td><td>{{ $cmd->patient->user->nom_complet ?? '—' }}</td><td>{{ number_format($cmd->montant_total,0,',',' ') }} FCFA</td></tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
