@extends('layouts.app')
@section('title', 'Mot de passe oublié — Furaso')

@section('content')
<div class="auth-wrap">
    <div class="card card-pad auth-card">
        <h2 class="text-center mb">Mot de passe oublié</h2>
        <p class="text-center muted mb">Saisissez votre email pour recevoir un lien de réinitialisation (par email ou SMS).</p>
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form-group"><label>Email</label><input type="email" name="email" value="{{ old('email') }}" required autofocus></div>
            <button class="btn btn-primary btn-block" type="submit">Envoyer le lien</button>
        </form>
        <p class="text-center mt"><a href="{{ route('login') }}">Retour à la connexion</a></p>
    </div>
</div>
@endsection
