@extends('layouts.dashboard')
@section('title', 'Pharmacies')

@section('content')
<div class="flex between center mb">
    <div><h1>Pharmacies partenaires</h1><p class="page-sub">Gérez le réseau de pharmacies.</p></div>
    <a href="{{ route('admin.pharmacies.create') }}" class="btn btn-primary">+ Nouvelle pharmacie</a>
</div>

@if($pharmacies->isEmpty())
    <div class="empty"><div class="ico"><i class="fa-solid fa-hospital"></i></div><p>Aucune pharmacie.</p></div>
@else
    <div class="card table-wrap">
        <table class="data">
            <thead><tr><th>Nom</th><th>Ville</th><th>Région</th><th>Médicaments</th><th>Partenaire</th><th></th></tr></thead>
            <tbody>
                @foreach($pharmacies as $ph)
                    <tr>
                        <td><strong>{{ $ph->nom }}</strong><br><span class="muted">{{ $ph->telephone }}</span></td>
                        <td>{{ $ph->ville }}</td>
                        <td>{{ $ph->region }}</td>
                        <td><span class="pill pill-blue">{{ $ph->medicaments_count }}</span></td>
                        <td>{!! $ph->partenaire ? '<span class="pill pill-green">Oui</span>' : '<span class="pill pill-gray">Non</span>' !!}</td>
                        <td class="flex gap-sm">
                            <a href="{{ route('admin.pharmacies.edit', $ph) }}" class="btn btn-outline btn-sm">Modifier</a>
                            <form method="POST" action="{{ route('admin.pharmacies.destroy', $ph) }}" onsubmit="return confirm('Supprimer cette pharmacie ?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm" type="submit">Suppr.</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt">{{ $pharmacies->links() }}</div>
@endif
@endsection
