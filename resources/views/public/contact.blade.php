@extends('layouts.app')
@section('title', 'Contact — Furaso')

@section('content')
<section class="hero" style="padding:50px 0">
    <div class="container"><h1>Contactez-nous</h1><p class="lead">Une question ? Notre équipe est à votre écoute.</p></div>
</section>

<section class="section">
    <div class="container grid grid-2">
        <div class="card card-pad">
            <h3 class="mb">Coordonnées</h3>
            <p class="mb">📞 <strong>Téléphone :</strong> +223 00 00 00 00</p>
            <p class="mb">✉️ <strong>Email :</strong> contact@furaso.ml</p>
            <p class="mb">💬 <strong>WhatsApp :</strong> +223 00 00 00 00</p>
            <p class="mb">📍 <strong>Adresse :</strong> Bamako, Mali</p>
        </div>
        <div class="card card-pad">
            <h3 class="mb">Envoyez-nous un message</h3>
            <form method="POST" action="{{ route('contact.envoyer') }}">
                @csrf
                <div class="form-group"><label>Nom complet</label><input type="text" name="nom" value="{{ old('nom') }}" required></div>
                <div class="form-group"><label>Email</label><input type="email" name="email" value="{{ old('email') }}" required></div>
                <div class="form-group"><label>Message</label><textarea name="message" rows="5" required>{{ old('message') }}</textarea></div>
                <button class="btn btn-primary btn-block" type="submit">Envoyer</button>
            </form>
        </div>
    </div>
</section>
@endsection
