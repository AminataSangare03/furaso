@extends('layouts.dashboard')
@section('title', 'Utilisateurs')

@section('content')
<div class="flex between center mb">
    <div><h1>Utilisateurs</h1><p class="page-sub">Gérez les patients, pharmaciens et administrateurs.</p></div>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">+ Nouvel utilisateur</a>
</div>

<div class="toolbar">
    <form method="GET" action="{{ route('admin.users.index') }}">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Rechercher...">
        <select name="role">
            <option value="">Tous les rôles</option>
            <option value="patient" @selected($role==='patient')>Patients</option>
            <option value="pharmacien" @selected($role==='pharmacien')>Pharmaciens</option>
            <option value="admin" @selected($role==='admin')>Administrateurs</option>
        </select>
        <button class="btn btn-secondary" type="submit">Filtrer</button>
    </form>
</div>

@if($users->isEmpty())
    <div class="empty"><div class="ico">👥</div><p>Aucun utilisateur.</p></div>
@else
    <div class="card table-wrap">
        <table class="data">
            <thead><tr><th>Nom</th><th>Email</th><th>Téléphone</th><th>Rôle</th><th></th></tr></thead>
            <tbody>
                @foreach($users as $u)
                    <tr>
                        <td>{{ $u->nom_complet }}</td>
                        <td>{{ $u->email }}</td>
                        <td>{{ $u->telephone ?: '—' }}</td>
                        <td><span class="pill {{ $u->role==='admin'?'pill-red':($u->role==='pharmacien'?'pill-blue':'pill-green') }}">{{ ucfirst($u->role) }}</span></td>
                        <td class="flex gap-sm">
                            <a href="{{ route('admin.users.edit', $u) }}" class="btn btn-outline btn-sm">Modifier</a>
                            <form method="POST" action="{{ route('admin.users.destroy', $u) }}" onsubmit="return confirm('Supprimer cet utilisateur ?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm" type="submit">Suppr.</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt">{{ $users->links() }}</div>
@endif
@endsection
