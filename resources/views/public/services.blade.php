@extends('layouts.app')
@section('title', 'Services — Furaso')

@section('content')
<section class="hero" style="padding:50px 0">
    <div class="container"><h1>Nos services</h1><p class="lead">Une gamme complète de services pour votre santé.</p></div>
</section>

<section class="section">
    <div class="container grid grid-2">
        <div class="card card-pad flex gap center"><div class="ico" style="width:56px;height:56px;border-radius:12px;background:var(--vert-clair);color:var(--vert);display:grid;place-items:center;font-size:1.6rem">💊</div><div><h3>Achat de médicaments</h3><p class="muted">Commandez des médicaments avec ou sans ordonnance, livrés chez vous.</p></div></div>
        <div class="card card-pad flex gap center"><div class="ico" style="width:56px;height:56px;border-radius:12px;background:var(--bleu-clair);color:var(--bleu);display:grid;place-items:center;font-size:1.6rem">📄</div><div><h3>Envoi d'ordonnance</h3><p class="muted">Photographiez ou téléversez votre ordonnance, validée par un pharmacien.</p></div></div>
        <div class="card card-pad flex gap center"><div class="ico" style="width:56px;height:56px;border-radius:12px;background:var(--vert-clair);color:var(--vert);display:grid;place-items:center;font-size:1.6rem">🚚</div><div><h3>Livraison à domicile</h3><p class="muted">Bamako (Communes I à VI) et toutes les régions du Mali.</p></div></div>
        <div class="card card-pad flex gap center"><div class="ico" style="width:56px;height:56px;border-radius:12px;background:var(--bleu-clair);color:var(--bleu);display:grid;place-items:center;font-size:1.6rem">💬</div><div><h3>Conseils pharmaceutiques</h3><p class="muted">Discutez en direct avec un pharmacien pour toute question.</p></div></div>
    </div>
    <div class="container text-center mt"><a href="{{ route('catalogue.index') }}" class="btn btn-primary">Commencer mes achats</a></div>
</section>
@endsection
