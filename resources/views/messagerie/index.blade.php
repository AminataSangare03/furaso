@extends('layouts.dashboard')
@section('title', 'Messagerie')

@section('content')
<h1>Messagerie</h1>
<p class="page-sub">Discutez avec {{ auth()->user()->isPatient() ? 'un pharmacien' : 'vos patients' }}.</p>

<div class="grid grid-2">
    <div class="card card-pad">
        <h3 class="mb">Mes conversations</h3>
        @forelse($contacts as $contact)
            <a href="{{ route('messagerie.show', $contact) }}" class="flex between center" style="padding:10px;border-radius:9px;border:1px solid var(--gris-clair);margin-bottom:8px;color:var(--texte)">
                <span class="icon-i"><i data-lucide="message-circle"></i> {{ $contact->nom_complet }} <span class="pill pill-gray">{{ ucfirst($contact->role) }}</span></span>
                <span class="muted"><i data-lucide="arrow-right"></i></span>
            </a>
        @empty
            <p class="muted">Aucune conversation pour l'instant.</p>
        @endforelse
    </div>

    <div class="card card-pad">
        <h3 class="mb">Démarrer une conversation</h3>
        @forelse($suggestions as $contact)
            <a href="{{ route('messagerie.show', $contact) }}" class="flex between center" style="padding:10px;border-radius:9px;border:1px solid var(--gris-clair);margin-bottom:8px;color:var(--texte)">
                <span class="icon-i">@if(auth()->user()->isPatient())<i class="fa-solid fa-user-doctor"></i>@else<i data-lucide="user"></i>@endif {{ $contact->nom_complet }}</span>
                <span class="btn btn-outline btn-sm">Écrire</span>
            </a>
        @empty
            <p class="muted">Aucun contact disponible.</p>
        @endforelse
    </div>
</div>
@endsection
