@extends('layouts.app')
@section('title', 'Connexion — Furaso')

@section('content')
<div class="auth-wrap">
    <div class="card card-pad auth-card">
        <h2 class="text-center mb">Connexion</h2>
        <p class="text-center muted mb">Accédez à votre espace Furaso</p>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group"><label>Email</label><input type="email" name="email" value="{{ old('email') }}" required autofocus></div>
            <div class="form-group"><label>Mot de passe</label><input type="password" name="password" required></div>
            <div class="form-group flex between center">
                <label style="font-weight:400"><input type="checkbox" name="remember" style="width:auto"> Se souvenir de moi</label>
                <a href="{{ route('password.request') }}">Mot de passe oublié ?</a>
            </div>
            <button class="btn btn-primary btn-block" type="submit">Se connecter</button>
        </form>
        <p class="text-center mt">Pas encore de compte ? <a href="{{ route('register') }}">Inscrivez-vous</a></p>
    </div>
</div>
@endsection
