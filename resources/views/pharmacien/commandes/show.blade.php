@extends('layouts.dashboard')
@section('title', 'Commande #'.$commande->id)

@section('content')
<a href="{{ route('pharmacien.commandes.index') }}" class="muted">← Retour</a>
<h1 class="mt">Commande #{{ $commande->id }}</h1>
<p class="page-sub">Patient : {{ $commande->patient->user->nom_complet ?? '—' }} · {{ $commande->created_at->format('d/m/Y H:i') }}</p>

<div class="grid grid-2">
    <div class="card card-pad">
        <h3 class="mb">Articles</h3>
        <table class="data">
            <thead><tr><th>Médicament</th><th>Qté</th><th>Sous-total</th></tr></thead>
            <tbody>
                @foreach($commande->details as $d)
                    <tr><td>{{ $d->nom_medicament }}</td><td>{{ $d->quantite }}</td><td>{{ number_format($d->sous_total,0,',',' ') }} FCFA</td></tr>
                @endforeach
            </tbody>
        </table>
        <div class="flex between mt"><span class="muted">Livraison ({{ $commande->zone_livraison }})</span><strong>{{ number_format($commande->frais_livraison,0,',',' ') }} FCFA</strong></div>
        <div class="flex between mt"><span><strong>Total</strong></span><strong style="color:var(--vert)">{{ number_format($commande->montant_total,0,',',' ') }} FCFA</strong></div>
        @if($commande->ordonnance)
            <p class="mt"><a href="{{ route('pharmacien.ordonnances.show', $commande->ordonnance) }}" class="btn btn-outline btn-sm">📄 Ordonnance liée #{{ $commande->ordonnance->id }}</a></p>
        @endif
    </div>

    <div>
        <div class="card card-pad mb">
            <h3 class="mb">Mettre à jour le statut</h3>
            <form method="POST" action="{{ route('pharmacien.commandes.statut', $commande) }}">
                @csrf @method('PUT')
                <div class="form-group">
                    <select name="statut">
                        @foreach(['en_attente'=>'En attente','confirmee'=>'Confirmée','preparee'=>'Préparée','expediee'=>'Expédiée','livree'=>'Livrée','annulee'=>'Annulée'] as $cle=>$lib)
                            <option value="{{ $cle }}" @selected($commande->statut===$cle)>{{ $lib }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="btn btn-primary btn-block" type="submit">Mettre à jour</button>
            </form>
        </div>
        <div class="card card-pad">
            <h3 class="mb">Livraison & paiement</h3>
            <p class="muted">📍 {{ $commande->adresse_livraison }}</p>
            <p class="muted">💳 {{ \App\Services\LivraisonService::modesPaiement()[$commande->mode_paiement] ?? $commande->mode_paiement }}</p>
            @if($commande->paiement)<p class="mt"><span class="pill {{ $commande->paiement->statut==='paye'?'pill-green':'pill-yellow' }}">Paiement : {{ ucfirst($commande->paiement->statut) }}</span></p>@endif
        </div>
    </div>
</div>
@endsection
