@extends('layouts.app')
@section('title', 'Réinitialiser le mot de passe — Furaso')

@section('content')
<div class="auth-wrap">
    <div class="card card-pad auth-card">
        <h2 class="text-center mb">Nouveau mot de passe</h2>
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-group"><label>Email</label><input type="email" name="email" value="{{ $email ?? old('email') }}" required></div>
            <div class="form-group"><label>Nouveau mot de passe</label><input type="password" name="password" required></div>
            <div class="form-group"><label>Confirmer le mot de passe</label><input type="password" name="password_confirmation" required></div>
            <button class="btn btn-primary btn-block" type="submit">Réinitialiser</button>
        </form>
    </div>
</div>
@endsection
