@extends('layouts.dashboard')
@section('title', 'Patient')

@section('content')
<a href="{{ route('pharmacien.patients.index') }}" class="muted"><i data-lucide="arrow-left"></i> Retour</a>
<h1 class="mt">{{ $patient->user->nom_complet ?? '—' }}</h1>
<p class="page-sub">{{ $patient->user->email }} · {{ $patient->user->telephone }}</p>

<div class="grid grid-2">
    <div class="card card-pad">
        <h3 class="mb">Informations</h3>
        <p class="muted">Sexe : {{ $patient->sexe ?: '—' }}</p>
        <p class="muted">Date de naissance : {{ optional($patient->date_naissance)->format('d/m/Y') ?: '—' }}</p>
        <p class="muted">Groupe sanguin : {{ $patient->groupe_sanguin ?: '—' }}</p>
        <p class="muted">Adresse : {{ $patient->user->adresse }} {{ $patient->user->quartier }}, {{ $patient->user->ville }}</p>
        <p class="muted">Contact urgence : {{ $patient->personne_urgence ?: '—' }} ({{ $patient->telephone_urgence ?: '—' }})</p>
        <a href="{{ route('messagerie.show', $patient->user) }}" class="btn btn-secondary btn-sm mt"><i data-lucide="message-circle"></i> Envoyer un message</a>
    </div>
    <div class="card card-pad">
        <h3 class="mb">Ordonnances ({{ $patient->ordonnances->count() }})</h3>
        @forelse($patient->ordonnances->take(5) as $ord)
            <div class="flex between center" style="padding:6px 0;border-bottom:1px solid var(--gris-clair)">
                <a href="{{ route('pharmacien.ordonnances.show',$ord) }}">#{{ $ord->id }}</a>
                <span class="pill {{ $ord->statut==='validee'?'pill-green':($ord->statut==='refusee'?'pill-red':'pill-yellow') }}">{{ $ord->statutLibelle() }}</span>
            </div>
        @empty
            <p class="muted">Aucune ordonnance.</p>
        @endforelse
    </div>
</div>

<div class="card card-pad mt">
    <h3 class="mb">Commandes ({{ $patient->commandes->count() }})</h3>
    <table class="data">
        <thead><tr><th>#</th><th>Date</th><th>Articles</th><th>Total</th><th>Statut</th></tr></thead>
        <tbody>
            @forelse($patient->commandes as $cmd)
                <tr>
                    <td>#{{ $cmd->id }}</td>
                    <td>{{ $cmd->created_at->format('d/m/Y') }}</td>
                    <td>{{ $cmd->details->count() }}</td>
                    <td>{{ number_format($cmd->montant_total,0,',',' ') }} FCFA</td>
                    <td><span class="pill pill-yellow">{{ $cmd->statutLibelle() }}</span></td>
                </tr>
            @empty
                <tr><td colspan="5" class="muted">Aucune commande.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
