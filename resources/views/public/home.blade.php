@extends('layouts.app')
@section('title', 'Furaso — Vos médicaments, simplement et en toute sécurité')

@section('content')
<section class="hero">
    <div class="container">
        <h1>Vos médicaments, simplement<br>et en toute sécurité.</h1>
        <p class="lead">Furaso vous permet de trouver vos médicaments, envoyer vos ordonnances, commander en ligne et vous faire livrer partout au Mali.</p>
        <div class="actions">
            <a href="{{ route('catalogue.index') }}" class="btn btn-primary">Voir le catalogue</a>
            <a href="{{ route('register') }}" class="btn btn-outline">Créer un compte</a>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <h2>Comment ça marche ?</h2>
        <p class="subtitle">Commander vos médicaments n'a jamais été aussi simple</p>
        <div class="grid grid-4">
            <div class="card feature"><div class="ico">🔍</div><h3>1. Recherchez</h3><p>Trouvez vos médicaments dans notre catalogue complet.</p></div>
            <div class="card feature bleu"><div class="ico">📷</div><h3>2. Envoyez l'ordonnance</h3><p>Prenez une photo ou téléversez un PDF de votre ordonnance.</p></div>
            <div class="card feature"><div class="ico">🛒</div><h3>3. Commandez</h3><p>Validez votre panier et choisissez votre mode de paiement.</p></div>
            <div class="card feature bleu"><div class="ico">🚚</div><h3>4. Livraison</h3><p>Recevez vos médicaments à domicile et suivez votre commande.</p></div>
        </div>
    </div>
</section>

<section class="section" style="background:#fff">
    <div class="container">
        <h2>Nos services</h2>
        <p class="subtitle">Tout ce dont vous avez besoin pour votre santé</p>
        <div class="grid grid-4">
            <div class="card feature"><div class="ico">💊</div><h3>Achat de médicaments</h3><p>Médicaments avec ou sans ordonnance.</p></div>
            <div class="card feature bleu"><div class="ico">📄</div><h3>Envoi d'ordonnance</h3><p>Validation par un pharmacien.</p></div>
            <div class="card feature"><div class="ico">🏠</div><h3>Livraison à domicile</h3><p>Bamako et toutes les régions.</p></div>
            <div class="card feature bleu"><div class="ico">💬</div><h3>Conseils pharmaceutiques</h3><p>Discutez avec un pharmacien.</p></div>
        </div>
    </div>
</section>

@if($populaires->isNotEmpty())
<section class="section">
    <div class="container">
        <h2>Médicaments populaires</h2>
        <p class="subtitle">Les produits les plus recherchés</p>
        <div class="grid grid-4">
            @foreach($populaires as $med)
                @include('catalogue.partials.carte', ['med' => $med])
            @endforeach
        </div>
        <div class="text-center mt"><a href="{{ route('catalogue.index') }}" class="btn btn-outline">Voir tout le catalogue</a></div>
    </div>
</section>
@endif

@if($pharmacies->isNotEmpty())
<section class="section" style="background:#fff">
    <div class="container">
        <h2>Pharmacies partenaires</h2>
        <p class="subtitle">Un réseau de pharmacies de confiance au Mali</p>
        <div class="grid grid-4">
            @foreach($pharmacies as $ph)
                <div class="card card-pad">
                    <div class="ico" style="width:48px;height:48px;border-radius:10px;background:var(--vert-clair);color:var(--vert);display:grid;place-items:center;font-size:1.3rem;margin-bottom:10px">🏥</div>
                    <h3 style="font-size:1.05rem">{{ $ph->nom }}</h3>
                    <p class="muted">{{ $ph->ville }}, {{ $ph->region }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="section">
    <div class="container">
        <h2>Ils nous font confiance</h2>
        <p class="subtitle">Témoignages de nos patients</p>
        <div class="grid grid-3">
            <div class="card card-pad"><p>« J'ai reçu mes médicaments en moins de 2 heures à Bamako. Service rapide et fiable ! »</p><p class="mt"><strong>Awa T.</strong> — Bamako</p></div>
            <div class="card card-pad"><p>« Envoyer mon ordonnance par photo est tellement pratique. Le pharmacien répond vite. »</p><p class="mt"><strong>Modibo K.</strong> — Ségou</p></div>
            <div class="card card-pad"><p>« Enfin une pharmacie en ligne adaptée au Mali avec Orange Money. Je recommande ! »</p><p class="mt"><strong>Fatoumata D.</strong> — Sikasso</p></div>
        </div>
    </div>
</section>

<section class="section" style="background:linear-gradient(135deg,var(--vert),var(--bleu));color:#fff">
    <div class="container text-center">
        <h2 style="color:#fff">Prêt à commander vos médicaments ?</h2>
        <p class="subtitle" style="color:#e0f2fe">Créez votre compte gratuitement et profitez de la livraison à domicile.</p>
        <a href="{{ route('register') }}" class="btn btn-primary" style="background:#fff;color:var(--vert-fonce)">Créer mon compte</a>
    </div>
</section>
@endsection
