@extends('layouts.app')
@section('title', 'Mon panier — Furaso')

@section('content')
<section class="section">
    <div class="container">
        <h1 class="mb">Mon panier</h1>

        @if($lignes->isEmpty())
            <div class="empty"><div class="ico">🛒</div><p>Votre panier est vide.</p><a href="{{ route('catalogue.index') }}" class="btn btn-primary mt">Découvrir le catalogue</a></div>
        @else
            <div class="grid" style="grid-template-columns:2fr 1fr;gap:24px">
                <div class="card">
                    <div class="table-wrap">
                        <table class="data">
                            <thead><tr><th>Médicament</th><th>Prix</th><th>Quantité</th><th>Sous-total</th><th></th></tr></thead>
                            <tbody>
                                @foreach($lignes as $ligne)
                                    <tr>
                                        <td>
                                            <strong>{{ $ligne['medicament']->nom }}</strong>
                                            @if($ligne['medicament']->ordonnance_obligatoire)<br><span class="pill pill-blue">Sur ordonnance</span>@endif
                                        </td>
                                        <td>{{ number_format($ligne['medicament']->prix, 0, ',', ' ') }} FCFA</td>
                                        <td>
                                            <form method="POST" action="{{ route('panier.modifier', $ligne['medicament']) }}" class="flex gap-sm center">
                                                @csrf @method('PATCH')
                                                <input type="number" name="quantite" value="{{ $ligne['quantite'] }}" min="1" style="width:70px">
                                                <button class="btn btn-ghost btn-sm" type="submit">OK</button>
                                            </form>
                                        </td>
                                        <td><strong>{{ number_format($ligne['sous_total'], 0, ',', ' ') }} FCFA</strong></td>
                                        <td>
                                            <form method="POST" action="{{ route('panier.supprimer', $ligne['medicament']) }}">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-danger btn-sm" type="submit">🗑️</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-pad">
                        <form method="POST" action="{{ route('panier.vider') }}">
                            @csrf @method('DELETE')
                            <button class="btn btn-ghost btn-sm" type="submit">Vider le panier</button>
                        </form>
                    </div>
                </div>

                <div class="card card-pad" style="align-self:start">
                    <h3 class="mb">Récapitulatif</h3>
                    <div class="flex between mb"><span class="muted">Total articles</span><strong>{{ number_format($total, 0, ',', ' ') }} FCFA</strong></div>
                    <p class="help mb">Les frais de livraison seront calculés à l'étape suivante selon votre zone.</p>

                    @if($contientOrdonnance)
                        <div class="alert alert-info">⚠️ Votre panier contient des médicaments sous ordonnance. Une ordonnance validée sera requise.</div>
                    @endif

                    @auth
                        @if(auth()->user()->isPatient())
                            <a href="{{ route('patient.checkout') }}" class="btn btn-primary btn-block">Passer la commande</a>
                        @else
                            <p class="muted">Connectez-vous avec un compte patient pour commander.</p>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-block">Se connecter pour commander</a>
                    @endauth
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
