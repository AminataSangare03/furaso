@php($panier = app(\App\Services\PanierService::class))
<nav class="navbar">
    <div class="container">
        <a href="{{ route('home') }}" class="brand">
            <span class="leaf">✚</span> Fura<span class="bleu">so</span>
        </a>
        <div class="nav-links">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Accueil</a>
            <a href="{{ route('catalogue.index') }}" class="{{ request()->routeIs('catalogue.*') ? 'active' : '' }}">Catalogue</a>
            <a href="{{ route('services') }}" class="{{ request()->routeIs('services') ? 'active' : '' }}">Services</a>
            <a href="{{ route('pharmacies') }}" class="{{ request()->routeIs('pharmacies') ? 'active' : '' }}">Pharmacies</a>
            <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">À propos</a>
            <a href="{{ route('faq') }}" class="{{ request()->routeIs('faq') ? 'active' : '' }}">FAQ</a>
            <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>

            <a href="{{ route('panier.index') }}" title="Panier">🛒
                @if($panier->nombreArticles() > 0)<span class="badge-count">{{ $panier->nombreArticles() }}</span>@endif
            </a>

            @auth
                @php($nonLues = auth()->user()->notificationsFuraso()->where('lu', false)->count())
                <a href="{{ route('notifications.index') }}" title="Notifications">🔔
                    @if($nonLues > 0)<span class="badge-count">{{ $nonLues }}</span>@endif
                </a>
                <a href="{{ route('dashboard') }}" class="btn btn-outline btn-sm">Mon espace</a>
                <form method="POST" action="{{ route('logout') }}" style="display:inline">
                    @csrf
                    <button class="btn btn-ghost btn-sm" type="submit">Déconnexion</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline btn-sm">Connexion</a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Inscription</a>
            @endauth
        </div>
    </div>
</nav>
