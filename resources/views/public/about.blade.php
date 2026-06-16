@extends('layouts.app')
@section('title', 'À propos — Furaso')

@section('content')
<section class="hero" style="padding:50px 0">
    <div class="container"><h1>À propos de Furaso</h1><p class="lead">Une pharmacie en ligne pensée pour les patients maliens.</p></div>
</section>

<section class="section">
    <div class="container grid grid-3">
        <div class="card card-pad"><div class="feature"><div class="ico">🎯</div><h3>Notre mission</h3><p>Faciliter l'accès aux médicaments pour tous les Maliens, en toute sécurité, où qu'ils se trouvent.</p></div></div>
        <div class="card card-pad"><div class="feature bleu"><div class="ico">👁️</div><h3>Notre vision</h3><p>Devenir la référence de la santé numérique au Mali, en connectant patients et pharmaciens.</p></div></div>
        <div class="card card-pad"><div class="feature"><div class="ico">🤝</div><h3>Notre équipe</h3><p>Des pharmaciens, développeurs et logisticiens engagés pour votre bien-être.</p></div></div>
    </div>
</section>

<section class="section" style="background:#fff">
    <div class="container">
        <h2>Pourquoi choisir Furaso ?</h2>
        <p class="subtitle">Des valeurs au service de votre santé</p>
        <div class="grid grid-4">
            <div class="card feature"><div class="ico">✅</div><h3>Fiabilité</h3><p>Médicaments authentiques de pharmacies agréées.</p></div>
            <div class="card feature bleu"><div class="ico">🔒</div><h3>Sécurité</h3><p>Vos données et ordonnances sont protégées.</p></div>
            <div class="card feature"><div class="ico">⚡</div><h3>Rapidité</h3><p>Livraison rapide à Bamako et dans les régions.</p></div>
            <div class="card feature bleu"><div class="ico">💚</div><h3>Proximité</h3><p>Un pharmacien à votre écoute à tout moment.</p></div>
        </div>
    </div>
</section>
@endsection
