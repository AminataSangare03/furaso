@extends('layouts.dashboard')
@section('title', 'Patients')

@section('content')
<h1>Patients</h1>
<p class="page-sub">Liste des patients et leur historique.</p>

<div class="toolbar">
    <form method="GET" action="{{ route('pharmacien.patients.index') }}">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Rechercher un patient...">
        <button class="btn btn-secondary" type="submit">Rechercher</button>
    </form>
</div>

@if($patients->isEmpty())
    <div class="empty"><div class="ico"><i data-lucide="users"></i></div><p>Aucun patient.</p></div>
@else
    <div class="card table-wrap">
        <table class="data">
            <thead><tr><th>Patient</th><th>Email</th><th>Téléphone</th><th>Commandes</th><th>Ordonnances</th><th></th></tr></thead>
            <tbody>
                @foreach($patients as $p)
                    <tr>
                        <td>{{ $p->user->nom_complet ?? '—' }}</td>
                        <td>{{ $p->user->email ?? '—' }}</td>
                        <td>{{ $p->user->telephone ?? '—' }}</td>
                        <td><span class="pill pill-blue">{{ $p->commandes_count }}</span></td>
                        <td><span class="pill pill-gray">{{ $p->ordonnances_count }}</span></td>
                        <td><a href="{{ route('pharmacien.patients.show', $p) }}" class="btn btn-outline btn-sm">Voir</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt">{{ $patients->links() }}</div>
@endif
@endsection
