@extends('layouts.app')
@section('title', 'Blog santé — Furaso')

@section('content')
<section class="hero" style="padding:50px 0">
    <div class="container"><h1>Blog santé</h1><p class="lead">Conseils et informations pour rester en bonne santé.</p></div>
</section>

<section class="section">
    <div class="container">
        @php($articles = [
            ['🩸', 'Diabète', 'Comment gérer son diabète au quotidien : alimentation, suivi et traitements.'],
            ['❤️', 'Hypertension', 'Prévenir et contrôler l\'hypertension artérielle naturellement.'],
            ['🦟', 'Paludisme', 'Reconnaître les symptômes du paludisme et bien se protéger.'],
            ['👩', 'Santé de la femme', 'Conseils santé essentiels pour les femmes à tout âge.'],
            ['🥗', 'Nutrition', 'Bien manger pour une meilleure santé : les bases de la nutrition.'],
            ['💊', 'Bon usage des médicaments', 'Comment bien prendre ses médicaments en toute sécurité.'],
        ])
        <div class="grid grid-3">
            @foreach($articles as $a)
                <div class="card produit">
                    <div class="thumb" style="font-size:3.5rem">{{ $a[0] }}</div>
                    <div class="body">
                        <span class="pill pill-green" style="align-self:flex-start">Santé</span>
                        <span class="nom">{{ $a[1] }}</span>
                        <p class="muted">{{ $a[2] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
