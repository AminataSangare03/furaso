@extends('layouts.dashboard')
@section('title', 'Commande #'.$commande->id)

@section('content')
<a href="{{ route('patient.commandes.index') }}" class="muted"><i data-lucide="arrow-left"></i> Retour</a>
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
            <h3 class="mb">Suivi de la livraison</h3>
            @php
                $etapes = ['confirmee'=>'Confirmée','preparee'=>'En préparation','expediee'=>'Livreur en route','livree'=>'Livrée'];
                $ordre = ['en_attente'=>0,'confirmee'=>1,'preparee'=>2,'expediee'=>3,'livree'=>4,'annulee'=>-1];
                $courant = $ordre[$commande->statut] ?? 0;
            @endphp
            @if($commande->statut === 'annulee')
                <p><span class="pill pill-red">Commande annulée</span></p>
            @else
                <ul class="suivi">
                    @foreach($etapes as $cle => $libelle)
                        @php($niveau = $ordre[$cle])
                        <li class="{{ $courant >= $niveau ? 'done' : '' }}">{{ $libelle }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
        <div class="card card-pad mb">
            <h3 class="mb">Détails de livraison</h3>
            <p class="muted"><i data-lucide="map-pin"></i> {{ $commande->adresse_livraison }}</p>
            <p class="muted"><i data-lucide="building-2"></i> Zone : {{ $commande->zone_livraison }}</p>
            <p class="muted"><i data-lucide="clock"></i> Créneau : {{ \App\Services\LivraisonService::creneauLibelle($commande->creneau) }}</p>
            <p class="muted"><i data-lucide="timer"></i> Délai estimé : {{ \App\Services\LivraisonService::delaiPour($commande->zone_livraison) }}</p>
            @if($commande->livraison && $commande->livraison->date_livraison_prevue)
                <p class="muted"><i data-lucide="calendar"></i> Arrivée prévue : {{ $commande->livraison->date_livraison_prevue->format('d/m/Y à H:i') }}</p>
            @endif
            @if($commande->livraison && $commande->livraison->livreur)
                <p class="muted"><i class="fa-solid fa-motorcycle"></i> Livreur : <strong>{{ $commande->livraison->livreur }}</strong>@if($commande->livraison->livreur_telephone) — {{ $commande->livraison->livreur_telephone }}@endif</p>
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
