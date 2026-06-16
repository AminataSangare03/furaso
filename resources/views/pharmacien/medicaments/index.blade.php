@extends('layouts.dashboard')
@section('title', 'Gestion des médicaments')

@section('content')
<div class="flex between center mb">
    <div><h1>Médicaments</h1><p class="page-sub">Gérez votre catalogue et vos stocks.</p></div>
    <a href="{{ route('pharmacien.medicaments.create') }}" class="btn btn-primary">+ Ajouter un médicament</a>
</div>

<div class="toolbar">
    <form method="GET" action="{{ route('pharmacien.medicaments.index') }}">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Rechercher...">
        <button class="btn btn-secondary" type="submit">Rechercher</button>
    </form>
</div>

@if($medicaments->isEmpty())
    <div class="empty"><div class="ico"><i class="fa-solid fa-pills"></i></div><p>Aucun médicament.</p></div>
@else
    <div class="card table-wrap">
        <table class="data">
            <thead><tr><th>Nom</th><th>Catégorie</th><th>Prix</th><th>Stock</th><th>Ordonnance</th><th></th></tr></thead>
            <tbody>
                @foreach($medicaments as $med)
                    <tr>
                        <td><strong>{{ $med->nom }}</strong><br><span class="muted">{{ $med->laboratoire }}</span></td>
                        <td>{{ $med->categorie->nom ?? '—' }}</td>
                        <td>{{ number_format($med->prix,0,',',' ') }} FCFA</td>
                        <td><span class="pill {{ $med->stock < 10 ? 'pill-red' : 'pill-green' }}">{{ $med->stock }}</span></td>
                        <td>{!! $med->ordonnance_obligatoire ? '<span class="pill pill-blue">Oui</span>' : '<span class="pill pill-gray">Non</span>' !!}</td>
                        <td class="flex gap-sm">
                            <a href="{{ route('pharmacien.medicaments.edit', $med) }}" class="btn btn-outline btn-sm">Modifier</a>
                            <form method="POST" action="{{ route('pharmacien.medicaments.destroy', $med) }}" onsubmit="return confirm('Supprimer ce médicament ?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm" type="submit">Suppr.</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt">{{ $medicaments->links() }}</div>
@endif
@endsection
