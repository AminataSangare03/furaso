@extends('layouts.dashboard')
@section('title', 'Mes favoris')

@section('content')
<h1>Mes médicaments favoris</h1>
<p class="page-sub">Retrouvez rapidement vos médicaments préférés.</p>

@if($favoris->isEmpty())
    <div class="empty"><div class="ico"><i data-lucide="star"></i></div><p>Aucun favori pour l'instant.</p><a href="{{ route('catalogue.index') }}" class="btn btn-primary mt">Parcourir le catalogue</a></div>
@else
    <div class="grid grid-4">
        @foreach($favoris as $med)
            @include('catalogue.partials.carte', ['med' => $med])
        @endforeach
    </div>
@endif
@endsection
