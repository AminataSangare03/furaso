@extends('layouts.dashboard')
@section('title', 'Discussion avec '.$interlocuteur->nom_complet)

@section('content')
<a href="{{ route('messagerie.index') }}" class="muted icon-i"><i data-lucide="arrow-left"></i> Toutes les conversations</a>
<h1 class="mt icon-i">@if(auth()->user()->isPatient())<i class="fa-solid fa-user-doctor"></i>@else<i data-lucide="user"></i>@endif {{ $interlocuteur->nom_complet }}</h1>
<p class="page-sub">{{ ucfirst($interlocuteur->role) }}</p>

<div class="card chat-thread">
    <div class="chat-messages" id="msgs">
        @forelse($messages as $msg)
            <div class="msg {{ (int) $msg->expediteur_id === (int) auth()->id() ? 'me' : 'them' }}">
                {{ $msg->message }}
                <span class="time">{{ $msg->created_at->format('d/m H:i') }}</span>
            </div>
        @empty
            <p class="muted text-center">Aucun message. Démarrez la conversation !</p>
        @endforelse
    </div>
    <form method="POST" action="{{ route('messagerie.store', $interlocuteur) }}" class="flex gap" style="padding:14px;border-top:1px solid var(--gris-clair)">
        @csrf
        <input type="text" name="message" placeholder="Votre message..." required autofocus>
        <button class="btn btn-primary" type="submit">Envoyer</button>
    </form>
</div>
<script>const m=document.getElementById('msgs');m.scrollTop=m.scrollHeight;</script>
@endsection
