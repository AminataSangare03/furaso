@extends('layouts.app')
@section('title', 'Livraison — Furaso')

@section('content')
<section class="hero" style="padding:50px 0">
    <div class="container">
        <h1>Livraison de vos médicaments</h1>
        <p class="lead">Partout à Bamako et dans toutes les régions du Mali — rapide, suivi, et payable à la livraison.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="grid grid-4">
            <div class="card feature"><div class="ico"><i data-lucide="zap"></i></div><h3>Livraison le jour même</h3><p>30 min à 3h sur Bamako selon votre quartier.</p></div>
            <div class="card feature bleu"><div class="ico"><i data-lucide="gift"></i></div><h3>Livraison gratuite</h3><p>Offerte dès {{ number_format($seuilGratuit,0,',',' ') }} FCFA d'achat.</p></div>
            <div class="card feature"><div class="ico"><i data-lucide="map-pin"></i></div><h3>Suivi en temps réel</h3><p>Suivez votre commande jusqu'à votre porte.</p></div>
            <div class="card feature bleu"><div class="ico"><i data-lucide="banknote"></i></div><h3>Payez à la réception</h3><p>Espèces, Orange Money ou Moov Money.</p></div>
        </div>
    </div>
</section>

<section class="section" style="background:#fff">
    <div class="container">
        <h2>Zones et tarifs de livraison</h2>
        <p class="subtitle">Choisissez votre quartier au moment de la commande, les frais s'appliquent automatiquement.</p>

        @php
            $parGroupe = [];
            foreach ($zones as $nom => $info) {
                $parGroupe[$info['groupe']]['frais'] = $info['frais'];
                $parGroupe[$info['groupe']]['delai'] = $info['delai'];
                $quartier = trim(preg_replace('/\(.*\)/', '', $nom));
                $parGroupe[$info['groupe']]['quartiers'][] = $quartier;
            }
        @endphp

        <table class="data" style="width:100%">
            <thead>
                <tr><th>Zone</th><th>Quartiers / villes desservis</th><th>Frais</th><th>Délai estimé</th></tr>
            </thead>
            <tbody>
                @foreach($parGroupe as $groupe => $info)
                    <tr>
                        <td><strong>{{ $groupe }}</strong></td>
                        <td class="muted">{{ implode(', ', $info['quartiers']) }}</td>
                        <td><strong>{{ number_format($info['frais'],0,',',' ') }} FCFA</strong></td>
                        <td>{{ $info['delai'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p class="help mt"><i data-lucide="lightbulb"></i> Livraison <strong>gratuite</strong> pour toute commande supérieure ou égale à {{ number_format($seuilGratuit,0,',',' ') }} FCFA, quelle que soit la zone.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <h2>Créneaux de livraison</h2>
        <p class="subtitle">Vous choisissez quand être livré.</p>
        <div class="grid grid-2">
            @foreach($creneaux as $cle => $libelle)
                <div class="card card-pad flex gap center">
                    <div class="ico" style="width:48px;height:48px;border-radius:12px;background:var(--vert-clair);color:var(--vert);display:grid;place-items:center;font-size:1.4rem"><i data-lucide="clock"></i></div>
                    <div><strong>{{ $libelle }}</strong></div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="section" style="background:#fff">
    <div class="container">
        <h2>Comment suivre ma livraison ?</h2>
        <p class="subtitle">À chaque étape, vous recevez une notification.</p>
        <div class="grid grid-4">
            <div class="card feature"><div class="ico"><i data-lucide="check-circle"></i></div><h3>1. Confirmée</h3><p>Votre commande est validée par la pharmacie.</p></div>
            <div class="card feature bleu"><div class="ico"><i data-lucide="package"></i></div><h3>2. En préparation</h3><p>Vos médicaments sont rassemblés et vérifiés.</p></div>
            <div class="card feature"><div class="ico"><i class="fa-solid fa-motorcycle"></i></div><h3>3. Livreur en route</h3><p>Le livreur part avec votre commande (nom et téléphone affichés).</p></div>
            <div class="card feature bleu"><div class="ico"><i data-lucide="home"></i></div><h3>4. Livrée</h3><p>Vous recevez vos médicaments et payez à la réception.</p></div>
        </div>
        <div class="text-center mt"><a href="{{ route('catalogue.index') }}" class="btn btn-primary">Commander maintenant</a></div>
    </div>
</section>
@endsection
