@extends('layouts.dashboard')
@section('title', 'Gestion des commandes')

@section('content')
<h1>Commandes</h1>
<p class="page-sub">Confirmez, préparez, expédiez et livrez les commandes.</p>

<div class="toolbar">
    <a href="{{ route('pharmacien.commandes.index') }}" class="btn btn-sm {{ ! $statut ? 'btn-primary' : 'btn-ghost' }}">Toutes</a>
    @foreach(['en_attente'=>'En attente','confirmee'=>'Confirmées','preparee'=>'Préparées','expediee'=>'Expédiées','livree'=>'Livrées'] as $cle=>$lib)
        <a href="{{ route('pharmacien.commandes.index', ['statut'=>$cle]) }}" class="btn btn-sm {{ $statut===$cle ? 'btn-primary' : 'btn-ghost' }}">{{ $lib }}</a>
    @endforeach
</div>

@if($commandes->isEmpty())
    <div class="empty"><div class="ico"><i data-lucide="package"></i></div><p>Aucune commande.</p></div>
@else
    <div class="card table-wrap">
        <table class="data">
            <thead><tr><th>#</th><th>Patient</th><th>Total</th><th>Zone</th><th>Statut</th><th></th></tr></thead>
            <tbody>
                @foreach($commandes as $cmd)
                    <tr>
                        <td>#{{ $cmd->id }}</td>
                        <td>{{ $cmd->patient->user->nom_complet ?? '—' }}</td>
                        <td>{{ number_format($cmd->montant_total,0,',',' ') }} FCFA</td>
                        <td>{{ $cmd->zone_livraison }}</td>
                        <td><span class="pill {{ $cmd->statut==='livree'?'pill-green':($cmd->statut==='annulee'?'pill-red':'pill-yellow') }}">{{ $cmd->statutLibelle() }}</span></td>
                        <td><a href="{{ route('pharmacien.commandes.show', $cmd) }}" class="btn btn-outline btn-sm">Gérer</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt">{{ $commandes->links() }}</div>
@endif
@endsection
