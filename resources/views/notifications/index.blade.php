@extends('layouts.dashboard')
@section('title', 'Notifications')

@section('content')
<div class="flex between center mb">
    <div><h1>Notifications</h1><p class="page-sub">Vos alertes et mises à jour.</p></div>
    <form method="POST" action="{{ route('notifications.tout-lire') }}">
        @csrf
        <button class="btn btn-ghost btn-sm" type="submit">Tout marquer comme lu</button>
    </form>
</div>

@if($notifications->isEmpty())
    <div class="empty"><div class="ico">🔔</div><p>Aucune notification.</p></div>
@else
    <div class="card">
        @foreach($notifications as $notif)
            <div class="flex between center" style="padding:14px 18px;border-bottom:1px solid var(--gris-clair);{{ $notif->lu ? '' : 'background:var(--vert-clair)' }}">
                <div>
                    <strong>{{ $notif->titre }}</strong> @if(! $notif->lu)<span class="pill pill-green">Nouveau</span>@endif
                    <br><span class="muted">{{ $notif->contenu }}</span>
                    <br><span class="help">{{ $notif->created_at->diffForHumans() }}</span>
                </div>
                @if($notif->lien)
                    <form method="POST" action="{{ route('notifications.lire', $notif) }}">
                        @csrf
                        <button class="btn btn-outline btn-sm" type="submit">Voir</button>
                    </form>
                @elseif(! $notif->lu)
                    <form method="POST" action="{{ route('notifications.lire', $notif) }}">
                        @csrf
                        <button class="btn btn-ghost btn-sm" type="submit">Marquer lu</button>
                    </form>
                @endif
            </div>
        @endforeach
    </div>
    <div class="mt">{{ $notifications->links() }}</div>
@endif
@endsection
