@extends('layouts.dashboard')
@section('title', 'Gestion des ordonnances')

@section('content')
<h1>Ordonnances</h1>
<p class="page-sub">Validez ou refusez les ordonnances des patients.</p>

<div class="toolbar">
    <a href="{{ route('pharmacien.ordonnances.index') }}" class="btn btn-sm {{ ! $statut ? 'btn-primary' : 'btn-ghost' }}">Toutes</a>
    <a href="{{ route('pharmacien.ordonnances.index', ['statut'=>'en_attente']) }}" class="btn btn-sm {{ $statut==='en_attente' ? 'btn-primary' : 'btn-ghost' }}">En attente</a>
    <a href="{{ route('pharmacien.ordonnances.index', ['statut'=>'validee']) }}" class="btn btn-sm {{ $statut==='validee' ? 'btn-primary' : 'btn-ghost' }}">Validées</a>
    <a href="{{ route('pharmacien.ordonnances.index', ['statut'=>'refusee']) }}" class="btn btn-sm {{ $statut==='refusee' ? 'btn-primary' : 'btn-ghost' }}">Refusées</a>
</div>

@if($ordonnances->isEmpty())
    <div class="empty"><div class="ico">📄</div><p>Aucune ordonnance.</p></div>
@else
    <div class="card table-wrap">
        <table class="data">
            <thead><tr><th>#</th><th>Patient</th><th>Type</th><th>Statut</th><th>Reçue le</th><th></th></tr></thead>
            <tbody>
                @foreach($ordonnances as $ord)
                    <tr>
                        <td>#{{ $ord->id }}</td>
                        <td>{{ $ord->patient->user->nom_complet ?? '—' }}</td>
                        <td>{{ strtoupper($ord->type) }}</td>
                        <td><span class="pill {{ $ord->statut==='validee'?'pill-green':($ord->statut==='refusee'?'pill-red':'pill-yellow') }}">{{ $ord->statutLibelle() }}</span></td>
                        <td>{{ optional($ord->date_envoi)->format('d/m/Y H:i') }}</td>
                        <td><a href="{{ route('pharmacien.ordonnances.show', $ord) }}" class="btn btn-outline btn-sm">Traiter</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt">{{ $ordonnances->links() }}</div>
@endif
@endsection
