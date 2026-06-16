@extends('layouts.dashboard')
@section('title', 'Commande #'.$commande->id)

@section('content')
<a href="{{ route('patient.commandes.index') }}" class="muted">← Retour</a>
<div class="flex between center mt mb">
    <h1>Commande #{{ $commande->id }}</h1>
    <span class="pill {{ $commande->statut==='livree'?'pill-green':($commande->statut==='annulee'?'pill-red':'pill-yellow') }}">{{ $commande->statutLibelle() }}</span>
</div>

<div class="grid grid-2">
    <div class="card card-pad">
        <h3 class="mb">Articles</h3>
        <table class="data">
            <thead><tr><th>Médicament</th><th>Qté</th><th>Prix</th><th>Sous-total</th></tr></thead>
            <tbody>
                @foreach($commande->details as $d)
                    <tr><td>{{ $d->nom_medicament }}</td><td>{{ $d->quantite }}</td><td>{{ number_format($d->prix,0,',',' ') }}</td><td>{{ number_format($d->sous_total,0,',',' ') }} FCFA</td></tr>
                @endforeach
            </tbody>
        </table>
        <div class="flex between mt"><span class="muted">Frais de livraison</span><strong>{{ number_format($commande->frais_livraison,0,',',' ') }} FCFA</strong></div>
        <div class="flex between mt"><span><strong>Total</strong></span><strong style="color:var(--vert);font-size:1.2rem">{{ number_format($commande->montant_total,0,',',' ') }} FCFA</strong></div>
    </div>

    <div>
        <div class="card card-pad mb">
            <h3 class="mb">Livraison</h3>
            <p class="muted">📍 {{ $commande->adresse_livraison }}</p>
            <p class="muted">🏙️ Zone : {{ $commande->zone_livraison }}</p>
            <p class="muted">⏱️ Délai estimé : {{ \App\Services\LivraisonService::delaiPour($commande->zone_livraison) }}</p>
            @if($commande->livraison)
                <p class="mt"><span class="pill pill-blue">{{ ucfirst(str_replace('_',' ',$commande->livraison->statut)) }}</span></p>
            @endif
        </div>
        <div class="card card-pad mb">
            <h3 class="mb">Paiement</h3>
            <p class="muted">Mode : {{ \App\Services\LivraisonService::modesPaiement()[$commande->mode_paiement] ?? $commande->mode_paiement }}</p>
            @if($commande->paiement)
                <p class="muted">Référence : {{ $commande->paiement->reference }}</p>
                <p class="mt"><span class="pill {{ $commande->paiement->statut==='paye'?'pill-green':'pill-yellow' }}">{{ ucfirst($commande->paiement->statut) }}</span></p>
            @endif
        </div>
        @if($commande->ordonnance)
            <div class="card card-pad">
                <h3 class="mb">Ordonnance liée</h3>
                <a href="{{ route('patient.ordonnances.show', $commande->ordonnance) }}" class="btn btn-outline btn-sm">Ordonnance #{{ $commande->ordonnance->id }}</a>
            </div>
        @endif
    </div>
</div>
@endsection
