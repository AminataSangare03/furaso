@extends('layouts.app')
@section('title', 'Catalogue des médicaments — Furaso')

@section('content')
<section class="hero" style="padding:44px 0">
    <div class="container">
        <h1>Catalogue des médicaments</h1>
        <form method="GET" action="{{ route('catalogue.index') }}" class="flex gap mt wrap">
            <input type="text" name="q" value="{{ $filtres['q'] ?? '' }}" placeholder="Rechercher par nom, maladie, laboratoire..." style="max-width:420px">
            <button class="btn btn-primary" type="submit"><i data-lucide="search"></i> Rechercher</button>
        </form>
    </div>
</section>

<section class="section">
    <div class="container" style="display:grid;grid-template-columns:250px 1fr;gap:24px">
        <aside class="card card-pad" style="align-self:start">
            <h3 class="mb">Filtres</h3>
            <form method="GET" action="{{ route('catalogue.index') }}">
                <input type="hidden" name="q" value="{{ $filtres['q'] ?? '' }}">
                <div class="form-group">
                    <label>Catégorie</label>
                    <select name="categorie">
                        <option value="">Toutes</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" @selected(($filtres['categorie'] ?? null) == $cat->id)>{{ $cat->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Ordonnance</label>
                    <select name="ordonnance">
                        <option value="">Tous</option>
                        <option value="0" @selected(($filtres['ordonnance'] ?? null) === '0')>Sans ordonnance</option>
                        <option value="1" @selected(($filtres['ordonnance'] ?? null) === '1')>Sur ordonnance</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Prix maximum (FCFA)</label>
                    <input type="number" name="prix_max" value="{{ $filtres['prix_max'] ?? '' }}" min="0">
                </div>
                <div class="form-group">
                    <label>Trier par</label>
                    <select name="tri">
                        <option value="nom" @selected(($filtres['tri'] ?? '') === 'nom')>Nom</option>
                        <option value="prix_asc" @selected(($filtres['tri'] ?? '') === 'prix_asc')>Prix croissant</option>
                        <option value="prix_desc" @selected(($filtres['tri'] ?? '') === 'prix_desc')>Prix décroissant</option>
                    </select>
                </div>
                <label style="font-weight:400"><input type="checkbox" name="disponible" value="1" style="width:auto" @checked(! empty($filtres['disponible']))> En stock uniquement</label>
                <button class="btn btn-primary btn-block mt" type="submit">Appliquer</button>
                <a href="{{ route('catalogue.index') }}" class="btn btn-ghost btn-block mt">Réinitialiser</a>
            </form>
        </aside>

        <div>
            <p class="muted mb">{{ $medicaments->total() }} médicament(s) trouvé(s)</p>
            @if($medicaments->isEmpty())
                <div class="empty"><div class="ico"><i class="fa-solid fa-pills"></i></div><p>Aucun médicament ne correspond à votre recherche.</p></div>
            @else
                <div class="grid grid-3">
                    @foreach($medicaments as $med)
                        @include('catalogue.partials.carte', ['med' => $med])
                    @endforeach
                </div>
                <div class="mt">{{ $medicaments->links() }}</div>
            @endif
        </div>
    </div>
</section>
@endsection
