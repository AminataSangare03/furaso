@extends('layouts.app')
@section('title', 'FAQ — Furaso')

@section('content')
<section class="hero" style="padding:50px 0">
    <div class="container"><h1>Questions fréquentes</h1><p class="lead">Tout ce que vous devez savoir sur Furaso.</p></div>
</section>

<section class="section">
    <div class="container" style="max-width:780px">
        @php($faqs = [
            ['Comment commander un médicament ?', 'Recherchez votre médicament dans le catalogue, ajoutez-le au panier puis validez votre commande. Vous choisissez ensuite votre mode de paiement et votre adresse de livraison.'],
            ['Comment envoyer mon ordonnance ?', 'Créez un compte, allez dans « Mes ordonnances » et prenez une photo ou téléversez un PDF. Un pharmacien la vérifiera et la validera.'],
            ['Quels sont les modes de paiement ?', 'Paiement à la livraison, Orange Money, Moov Money et carte bancaire.'],
            ['Où livrez-vous ?', 'Partout au Mali : Bamako (Communes I à VI) et toutes les régions (Kayes, Koulikoro, Sikasso, Ségou, Mopti, Tombouctou, Gao, Kidal).'],
            ['Puis-je acheter un médicament sous ordonnance ?', 'Oui, mais vous devez d\'abord envoyer une ordonnance valide qui sera validée par un pharmacien.'],
            ['Comment suivre ma commande ?', 'Depuis votre tableau de bord, rubrique « Mes commandes », vous suivez l\'état de votre commande en temps réel.'],
        ])
        @foreach($faqs as $faq)
            <details class="card card-pad mb">
                <summary style="font-weight:700;cursor:pointer">{{ $faq[0] }}</summary>
                <p class="muted mt">{{ $faq[1] }}</p>
            </details>
        @endforeach
    </div>
</section>
@endsection
