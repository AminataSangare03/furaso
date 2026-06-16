@php($u = auth()->user())
<aside class="sidebar">
    @if($u->isPatient())
        <div class="role-tag">Espace Patient</div>
        <a href="{{ route('patient.dashboard') }}" class="{{ request()->routeIs('patient.dashboard') ? 'active' : '' }}">🏠 Accueil</a>
        <a href="{{ route('patient.profil.edit') }}" class="{{ request()->routeIs('patient.profil.*') ? 'active' : '' }}">👤 Mon profil</a>
        <a href="{{ route('patient.ordonnances.index') }}" class="{{ request()->routeIs('patient.ordonnances.*') ? 'active' : '' }}">📄 Mes ordonnances</a>
        <a href="{{ route('patient.commandes.index') }}" class="{{ request()->routeIs('patient.commandes.*') ? 'active' : '' }}">📦 Mes commandes</a>
        <a href="{{ route('patient.favoris.index') }}" class="{{ request()->routeIs('patient.favoris.*') ? 'active' : '' }}">⭐ Mes favoris</a>
        <a href="{{ route('catalogue.index') }}">💊 Catalogue</a>
        <a href="{{ route('messagerie.index') }}" class="{{ request()->routeIs('messagerie.*') ? 'active' : '' }}">💬 Messagerie</a>
        <a href="{{ route('notifications.index') }}" class="{{ request()->routeIs('notifications.*') ? 'active' : '' }}">🔔 Notifications</a>
    @elseif($u->isPharmacien())
        <div class="role-tag">Espace Pharmacien</div>
        <a href="{{ route('pharmacien.dashboard') }}" class="{{ request()->routeIs('pharmacien.dashboard') ? 'active' : '' }}">📊 Tableau de bord</a>
        <a href="{{ route('pharmacien.medicaments.index') }}" class="{{ request()->routeIs('pharmacien.medicaments.*') ? 'active' : '' }}">💊 Médicaments</a>
        <a href="{{ route('pharmacien.ordonnances.index') }}" class="{{ request()->routeIs('pharmacien.ordonnances.*') ? 'active' : '' }}">📄 Ordonnances</a>
        <a href="{{ route('pharmacien.commandes.index') }}" class="{{ request()->routeIs('pharmacien.commandes.*') ? 'active' : '' }}">📦 Commandes</a>
        <a href="{{ route('pharmacien.patients.index') }}" class="{{ request()->routeIs('pharmacien.patients.*') ? 'active' : '' }}">👥 Patients</a>
        <a href="{{ route('messagerie.index') }}" class="{{ request()->routeIs('messagerie.*') ? 'active' : '' }}">💬 Messagerie</a>
        <a href="{{ route('notifications.index') }}" class="{{ request()->routeIs('notifications.*') ? 'active' : '' }}">🔔 Notifications</a>
    @else
        <div class="role-tag">Administration</div>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">📊 Tableau de bord</a>
        <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">👥 Utilisateurs</a>
        <a href="{{ route('admin.pharmacies.index') }}" class="{{ request()->routeIs('admin.pharmacies.*') ? 'active' : '' }}">🏥 Pharmacies</a>
        <a href="{{ route('pharmacien.medicaments.index') }}">💊 Médicaments</a>
        <a href="{{ route('pharmacien.commandes.index') }}">📦 Commandes</a>
        <a href="{{ route('messagerie.index') }}" class="{{ request()->routeIs('messagerie.*') ? 'active' : '' }}">💬 Messagerie</a>
        <a href="{{ route('notifications.index') }}" class="{{ request()->routeIs('notifications.*') ? 'active' : '' }}">🔔 Notifications</a>
    @endif
</aside>
