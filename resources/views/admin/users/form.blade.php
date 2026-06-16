@extends('layouts.dashboard')
@section('title', $user->exists ? 'Modifier un utilisateur' : 'Nouvel utilisateur')

@section('content')
<a href="{{ route('admin.users.index') }}" class="muted"><i data-lucide="arrow-left"></i> Retour</a>
<h1 class="mt">{{ $user->exists ? 'Modifier l\'utilisateur' : 'Nouvel utilisateur' }}</h1>

<div class="card card-pad" style="max-width:720px">
    <form method="POST" action="{{ $user->exists ? route('admin.users.update', $user) : route('admin.users.store') }}">
        @csrf
        @if($user->exists) @method('PUT') @endif
        <div class="row-2">
            <div class="form-group"><label>Nom *</label><input type="text" name="name" value="{{ old('name',$user->name) }}" required></div>
            <div class="form-group"><label>Prénom</label><input type="text" name="prenom" value="{{ old('prenom',$user->prenom) }}"></div>
        </div>
        <div class="row-2">
            <div class="form-group"><label>Email *</label><input type="email" name="email" value="{{ old('email',$user->email) }}" required></div>
            <div class="form-group"><label>Téléphone</label><input type="text" name="telephone" value="{{ old('telephone',$user->telephone) }}"></div>
        </div>
        <div class="form-group">
            <label>Rôle *</label>
            <select name="role" id="role" required>
                <option value="patient" @selected(old('role',$user->role)==='patient')>Patient</option>
                <option value="pharmacien" @selected(old('role',$user->role)==='pharmacien')>Pharmacien</option>
                <option value="admin" @selected(old('role',$user->role)==='admin')>Administrateur</option>
            </select>
        </div>
        <div id="pharmacien-fields" class="row-2" style="display:none">
            <div class="form-group">
                <label>Pharmacie</label>
                <select name="pharmacie_id">
                    <option value="">—</option>
                    @foreach($pharmacies as $ph)<option value="{{ $ph->id }}" @selected(old('pharmacie_id', optional($user->pharmacien)->pharmacie_id)==$ph->id)>{{ $ph->nom }}</option>@endforeach
                </select>
            </div>
            <div class="form-group"><label>Numéro d'ordre</label><input type="text" name="numero_ordre" value="{{ old('numero_ordre', optional($user->pharmacien)->numero_ordre) }}"></div>
        </div>
        <div class="row-2">
            <div class="form-group"><label>{{ $user->exists ? 'Nouveau mot de passe (laisser vide pour ne pas changer)' : 'Mot de passe *' }}</label><input type="password" name="password" {{ $user->exists ? '' : 'required' }}></div>
            <div class="form-group"><label>Confirmer</label><input type="password" name="password_confirmation"></div>
        </div>
        <button class="btn btn-primary" type="submit">Enregistrer</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-ghost">Annuler</a>
    </form>
</div>

<script>
    const role = document.getElementById('role');
    const fields = document.getElementById('pharmacien-fields');
    function toggle() { fields.style.display = role.value === 'pharmacien' ? 'grid' : 'none'; }
    role.addEventListener('change', toggle);
    toggle();
</script>
@endsection
