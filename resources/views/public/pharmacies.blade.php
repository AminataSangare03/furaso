@extends('layouts.app')
@section('title', 'Pharmacies partenaires — Furaso')

@section('content')
<section class="hero" style="padding:50px 0">
    <div class="container"><h1>Pharmacies partenaires</h1><p class="lead">Un réseau de pharmacies agréées partout au Mali.</p></div>
</section>

<section class="section">
    <div class="container">
        @if($pharmacies->isEmpty())
            <div class="empty"><div class="ico"><i class="fa-solid fa-hospital"></i></div><p>Aucune pharmacie partenaire pour le moment.</p></div>
        @else
            <div class="grid grid-3">
                @foreach($pharmacies as $ph)
                    <div class="card card-pad">
                        <div class="flex between center mb">
                            <div class="ico" style="width:48px;height:48px;border-radius:10px;background:var(--vert-clair);color:var(--vert);display:grid;place-items:center;font-size:1.3rem"><i class="fa-solid fa-hospital"></i></div>
                            @if($ph->partenaire)<span class="pill pill-green">Partenaire</span>@endif
                        </div>
                        <h3>{{ $ph->nom }}</h3>
                        <p class="muted"><i data-lucide="map-pin"></i> {{ $ph->adresse ?: '—' }}</p>
                        <p class="muted"><i data-lucide="building-2"></i> {{ $ph->ville }}, {{ $ph->region }}</p>
                        @if($ph->telephone)<p class="muted"><i data-lucide="phone"></i> {{ $ph->telephone }}</p>@endif
                        <p class="mt"><span class="pill pill-blue">{{ $ph->medicaments_count }} médicaments</span></p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
