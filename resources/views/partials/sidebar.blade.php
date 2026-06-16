@php($u = auth()->user())
<aside class="sidebar">
    @if($u->isPatient())
        <div class="role-tag">Espace Patient</div>
        <a href="{{ route('patient.dashboard') }}" class="{{ request()->routeIs('patient.dashboard') ? 'active' : '' }}"><i data-lucide="home"></i> Accueil</a>
        <a href="{{ route('patient.profil.edit') }}" class="{{ request()->routeIs('patient.profil.*') ? 'active' : '' }}"><i data-lucide="user"></i> Mon profil</a>
        <a href="{{ route('patient.ordonnances.index') }}" class="{{ request()->routeIs('patient.ordonnances.*') ? 'active' : '' }}"><i data-lucide="file-text"></i> Mes ordonnances</a>
        <a href="{{ route('patient.commandes.index') }}" class="{{ request()->routeIs('patient.commandes.*') ? 'active' : '' }}"><i data-lucide="package"></i> Mes commandes</a>
        <a href="{{ route('patient.favoris.index') }}" class="{{ request()->routeIs('patient.favoris.*') ? 'active' : '' }}"><i data-lucide="star"></i> Mes favoris</a>
        <a href="{{ route('catalogue.index') }}"><i class="fa-solid fa-pills"></i> Catalogue</a>
        <a href="{{ route('messagerie.index') }}" class="{{ request()->routeIs('messagerie.*') ? 'active' : '' }}"><i data-lucide="message-circle"></i> Messagerie</a>
        <a href="{{ route('notifications.index') }}" class="{{ request()->routeIs('notifications.*') ? 'active' : '' }}"><i data-lucide="bell"></i> Notifications</a>
    @elseif($u->isPharmacien())
        <div class="role-tag">Espace Pharmacien</div>
        <a href="{{ route('pharmacien.dashboard') }}" class="{{ request()->routeIs('pharmacien.dashboard') ? 'active' : '' }}"><i data-lucide="bar-chart-3"></i> Tableau de bord</a>
        <a href="{{ route('pharmacien.medicaments.index') }}" class="{{ request()->routeIs('pharmacien.medicaments.*') ? 'active' : '' }}"><i class="fa-solid fa-pills"></i> Médicaments</a>
        <a href="{{ route('pharmacien.ordonnances.index') }}" class="{{ request()->routeIs('pharmacien.ordonnances.*') ? 'active' : '' }}"><i data-lucide="file-text"></i> Ordonnances</a>
        <a href="{{ route('pharmacien.commandes.index') }}" class="{{ request()->routeIs('pharmacien.commandes.*') ? 'active' : '' }}"><i data-lucide="package"></i> Commandes</a>
        <a href="{{ route('pharmacien.patients.index') }}" class="{{ request()->routeIs('pharmacien.patients.*') ? 'active' : '' }}"><i data-lucide="users"></i> Patients</a>
        <a href="{{ route('messagerie.index') }}" class="{{ request()->routeIs('messagerie.*') ? 'active' : '' }}"><i data-lucide="message-circle"></i> Messagerie</a>
        <a href="{{ route('notifications.index') }}" class="{{ request()->routeIs('notifications.*') ? 'active' : '' }}"><i data-lucide="bell"></i> Notifications</a>
    @else
        <div class="role-tag">Administration</div>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i data-lucide="bar-chart-3"></i> Tableau de bord</a>
        <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}"><i data-lucide="users"></i> Utilisateurs</a>
        <a href="{{ route('admin.pharmacies.index') }}" class="{{ request()->routeIs('admin.pharmacies.*') ? 'active' : '' }}"><i class="fa-solid fa-hospital"></i> Pharmacies</a>
        <a href="{{ route('pharmacien.medicaments.index') }}"><i class="fa-solid fa-pills"></i> Médicaments</a>
        <a href="{{ route('pharmacien.commandes.index') }}"><i data-lucide="package"></i> Commandes</a>
        <a href="{{ route('messagerie.index') }}" class="{{ request()->routeIs('messagerie.*') ? 'active' : '' }}"><i data-lucide="message-circle"></i> Messagerie</a>
        <a href="{{ route('notifications.index') }}" class="{{ request()->routeIs('notifications.*') ? 'active' : '' }}"><i data-lucide="bell"></i> Notifications</a>
    @endif
</aside>
