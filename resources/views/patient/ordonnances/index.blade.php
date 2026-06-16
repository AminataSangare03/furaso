@extends('layouts.dashboard')
@section('title', 'Mes ordonnances')

@section('content')
<div class="flex between center mb">
    <div><h1>Mes ordonnances</h1><p class="page-sub">Suivez l'état de vos ordonnances.</p></div>
    <a href="{{ route('patient.ordonnances.create') }}" class="btn btn-primary">+ Envoyer une ordonnance</a>
</div>

@if($ordonnances->isEmpty())
    <div class="empty"><div class="ico"><i data-lucide="file-text"></i></div><p>Aucune ordonnance envoyée.</p></div>
@else
    <div class="card table-wrap">
        <table class="data">
            <thead><tr><th>#</th><th>Type</th><th>Pharmacie</th><th>Statut</th><th>Date d'envoi</th><th></th></tr></thead>
            <tbody>
                @foreach($ordonnances as $ord)
                    <tr>
                        <td>#{{ $ord->id }}</td>
                        <td>{{ strtoupper($ord->type) }}</td>
                        <td>{{ $ord->pharmacie->nom ?? '—' }}</td>
                        <td><span class="pill {{ $ord->statut==='validee'?'pill-green':($ord->statut==='refusee'?'pill-red':'pill-yellow') }}">{{ $ord->statutLibelle() }}</span></td>
                        <td>{{ optional($ord->date_envoi)->format('d/m/Y H:i') }}</td>
                        <td><a href="{{ route('patient.ordonnances.show', $ord) }}" class="btn btn-outline btn-sm">Voir</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt">{{ $ordonnances->links() }}</div>
@endif
@endsection
