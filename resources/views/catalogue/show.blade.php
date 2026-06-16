@extends('layouts.app')
@section('title', $medicament->nom.' — Furaso')

@section('content')
<section class="section">
    <div class="container">
        <a href="{{ route('catalogue.index') }}" class="muted">← Retour au catalogue</a>
        <div class="grid grid-2 mt">
            <div class="card" style="overflow:hidden">
                <div class="thumb" style="height:320px;background:var(--vert-clair);display:grid;place-items:center;font-size:7rem;color:var(--vert)">
                    @if($medicament->image)<img src="{{ asset('storage/'.$medicament->image) }}" alt="{{ $medicament->nom }}" style="height:100%;width:100%;object-fit:cover">@else 💊 @endif
                </div>
            </div>
            <div>
                <div class="flex gap-sm wrap mb">
                    @if($medicament->categorie)<span class="pill pill-gray">{{ $medicament->categorie->nom }}</span>@endif
                    @if($medicament->ordonnance_obligatoire)<span class="pill pill-blue">Sur ordonnance</span>@else<span class="pill pill-green">Sans ordonnance</span>@endif
                    @if($medicament->stock > 0)<span class="pill pill-green">En stock ({{ $medicament->stock }})</span>@else<span class="pill pill-red">Rupture de stock</span>@endif
                </div>
                <h1>{{ $medicament->nom }}</h1>
                <p class="muted">{{ $medicament->laboratoire ?: 'Laboratoire générique' }} @if($medicament->dosage)· {{ $medicament->dosage }}@endif</p>
                <p style="font-size:2rem;color:var(--vert);font-weight:800;margin:14px 0">{{ number_format($medicament->prix, 0, ',', ' ') }} FCFA</p>

                @if($medicament->description)<p class="mb">{{ $medicament->description }}</p>@endif

                @if($medicament->ordonnance_obligatoire)
                    <div class="alert alert-info">⚠️ Ce médicament nécessite une ordonnance valide. Envoyez votre ordonnance depuis votre espace patient.</div>
                @endif

                <div class="flex gap wrap mt">
                    @if($medicament->stock > 0 && ! $medicament->ordonnance_obligatoire)
                        <form method="POST" action="{{ route('panier.ajouter', $medicament) }}" class="flex gap center">
                            @csrf
                            <input type="number" name="quantite" value="1" min="1" max="{{ $medicament->stock }}" style="width:80px">
                            <button class="btn btn-primary" type="submit">🛒 Ajouter au panier</button>
                        </form>
                    @elseif($medicament->ordonnance_obligatoire)
                        @auth
                            <a href="{{ route('patient.ordonnances.create') }}" class="btn btn-secondary">📄 Envoyer mon ordonnance</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-secondary">Connectez-vous pour commander</a>
                        @endauth
                    @endif
                    @auth
                        @if(auth()->user()->isPatient())
                            <form method="POST" action="{{ route('patient.favoris.toggle', $medicament) }}">
                                @csrf
                                <button class="btn btn-outline" type="submit">⭐ Favori</button>
                            </form>
                        @endif
                    @endauth
                </div>
            </div>
        </div>

        <div class="grid grid-2 mt">
            @if($medicament->effets_secondaires)
                <div class="card card-pad"><h3 class="mb">Effets secondaires</h3><p class="muted">{{ $medicament->effets_secondaires }}</p></div>
            @endif
            @if($medicament->conseils_utilisation)
                <div class="card card-pad"><h3 class="mb">Conseils d'utilisation</h3><p class="muted">{{ $medicament->conseils_utilisation }}</p></div>
            @endif
        </div>

        @if($similaires->isNotEmpty())
            <h2 class="mt" style="margin-top:40px">Produits similaires</h2>
            <div class="grid grid-4 mt">
                @foreach($similaires as $med)
                    @include('catalogue.partials.carte', ['med' => $med])
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
