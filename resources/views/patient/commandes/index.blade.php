@extends('layouts.dashboard')
@section('title', 'Mes commandes')

@section('content')
<h1>Mes commandes</h1>
<p class="page-sub">Historique et suivi de vos commandes.</p>

@if($commandes->isEmpty())
    <div class="empty"><div class="ico">📦</div><p>Aucune commande.</p><a href="{{ route('catalogue.index') }}" class="btn btn-primary mt">Commander</a></div>
@else
    <div class="card table-wrap">
        <table class="data">
            <thead><tr><th>#</th><th>Date</th><th>Articles</th><th>Total</th><th>Paiement</th><th>Statut</th><th></th></tr></thead>
            <tbody>
                @foreach($commandes as $cmd)
                    <tr>
                        <td>#{{ $cmd->id }}</td>
                        <td>{{ $cmd->created_at->format('d/m/Y') }}</td>
                        <td>{{ $cmd->details->count() }}</td>
                        <td><strong>{{ number_format($cmd->montant_total,0,',',' ') }} FCFA</strong></td>
                        <td><span class="pill pill-gray">{{ \App\Services\LivraisonService::modesPaiement()[$cmd->mode_paiement] ?? $cmd->mode_paiement }}</span></td>
                        <td><span class="pill {{ in_array($cmd->statut,['livree'])?'pill-green':(in_array($cmd->statut,['annulee'])?'pill-red':'pill-yellow') }}">{{ $cmd->statutLibelle() }}</span></td>
                        <td><a href="{{ route('patient.commandes.show', $cmd) }}" class="btn btn-outline btn-sm">Détails</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt">{{ $commandes->links() }}</div>
@endif
@endsection
