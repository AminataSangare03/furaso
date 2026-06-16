@extends('layouts.dashboard')
@section('title', $medicament->exists ? 'Modifier un médicament' : 'Ajouter un médicament')

@section('content')
<a href="{{ route('pharmacien.medicaments.index') }}" class="muted">← Retour</a>
<h1 class="mt">{{ $medicament->exists ? 'Modifier le médicament' : 'Ajouter un médicament' }}</h1>

<div class="card card-pad" style="max-width:800px">
    <form method="POST" action="{{ $medicament->exists ? route('pharmacien.medicaments.update', $medicament) : route('pharmacien.medicaments.store') }}" enctype="multipart/form-data">
        @csrf
        @if($medicament->exists) @method('PUT') @endif

        <div class="row-2">
            <div class="form-group"><label>Nom *</label><input type="text" name="nom" value="{{ old('nom',$medicament->nom) }}" required></div>
            <div class="form-group"><label>Laboratoire</label><input type="text" name="laboratoire" value="{{ old('laboratoire',$medicament->laboratoire) }}"></div>
        </div>
        <div class="row-2">
            <div class="form-group">
                <label>Catégorie</label>
                <select name="categorie_id">
                    <option value="">—</option>
                    @foreach($categories as $cat)<option value="{{ $cat->id }}" @selected(old('categorie_id',$medicament->categorie_id)==$cat->id)>{{ $cat->nom }}</option>@endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Pharmacie</label>
                <select name="pharmacie_id">
                    <option value="">—</option>
                    @foreach($pharmacies as $ph)<option value="{{ $ph->id }}" @selected(old('pharmacie_id',$medicament->pharmacie_id)==$ph->id)>{{ $ph->nom }}</option>@endforeach
                </select>
            </div>
        </div>
        <div class="row-2">
            <div class="form-group"><label>Dosage</label><input type="text" name="dosage" value="{{ old('dosage',$medicament->dosage) }}" placeholder="ex: 500mg"></div>
            <div class="form-group"><label>Maladie / indication</label><input type="text" name="maladie" value="{{ old('maladie',$medicament->maladie) }}"></div>
        </div>
        <div class="row-2">
            <div class="form-group"><label>Prix (FCFA) *</label><input type="number" step="0.01" name="prix" value="{{ old('prix',$medicament->prix) }}" required></div>
            <div class="form-group"><label>Stock *</label><input type="number" name="stock" value="{{ old('stock',$medicament->stock ?? 0) }}" required></div>
        </div>
        <div class="form-group"><label>Description</label><textarea name="description" rows="3">{{ old('description',$medicament->description) }}</textarea></div>
        <div class="row-2">
            <div class="form-group"><label>Effets secondaires</label><textarea name="effets_secondaires" rows="2">{{ old('effets_secondaires',$medicament->effets_secondaires) }}</textarea></div>
            <div class="form-group"><label>Conseils d'utilisation</label><textarea name="conseils_utilisation" rows="2">{{ old('conseils_utilisation',$medicament->conseils_utilisation) }}</textarea></div>
        </div>
        <div class="row-2">
            <div class="form-group"><label>Date d'expiration</label><input type="date" name="date_expiration" value="{{ old('date_expiration', optional($medicament->date_expiration)->format('Y-m-d')) }}"></div>
            <div class="form-group"><label>Image</label><input type="file" name="image" accept="image/*"></div>
        </div>
        <div class="form-group">
            <label style="font-weight:400"><input type="checkbox" name="ordonnance_obligatoire" value="1" style="width:auto" @checked(old('ordonnance_obligatoire',$medicament->ordonnance_obligatoire))> Nécessite une ordonnance</label>
        </div>
        <button class="btn btn-primary" type="submit">Enregistrer</button>
        <a href="{{ route('pharmacien.medicaments.index') }}" class="btn btn-ghost">Annuler</a>
    </form>
</div>
@endsection
