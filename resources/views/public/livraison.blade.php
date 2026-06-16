@extends('layouts.app')
@section('title', 'Livraison — Furaso')

@section('content')
{{-- Tailwind via CDN (sans build), preflight désactivé pour préserver la navbar/footer du site --}}
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        corePlugins: { preflight: false, container: false },
        theme: {
            extend: {
                colors: {
                    furaso: { DEFAULT: '#16A34A', dark: '#15803D', light: '#DCFCE7' },
                    medical: { DEFAULT: '#2563EB', light: '#DBEAFE' },
                },
                fontFamily: { sans: ['Inter', 'Segoe UI', 'system-ui', 'sans-serif'] },
                boxShadow: { soft: '0 20px 45px -20px rgba(16,163,74,.35)' },
            },
        },
    };
</script>

<div class="tw-livraison font-sans text-slate-700 antialiased [&_h1]:m-0 [&_h2]:m-0 [&_h3]:m-0 [&_p]:m-0">

    {{-- ========== 1. HÉROS ========== --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-furaso-light via-emerald-50 to-white">
        <div class="pointer-events-none absolute -top-24 -right-24 h-80 w-80 rounded-full bg-furaso/20 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-28 -left-20 h-80 w-80 rounded-full bg-medical/10 blur-3xl"></div>
        <div class="pointer-events-none absolute inset-0 opacity-[0.06]"
             style="background-image:radial-gradient(#16A34A 1.4px, transparent 1.4px);background-size:26px 26px;"></div>

        <div class="relative mx-auto max-w-6xl px-6 py-20 sm:py-28 text-center">
            <span class="inline-flex items-center gap-2 rounded-full bg-white/80 px-4 py-1.5 text-sm font-semibold text-furaso-dark shadow-sm ring-1 ring-furaso/20 backdrop-blur">
                <i data-lucide="truck" class="h-4 w-4"></i> Livraison rapide au Mali
            </span>
            <h1 class="mt-6 text-4xl font-extrabold tracking-tight text-slate-900 sm:text-6xl">
                Livraison de vos médicaments
            </h1>
            <p class="mx-auto mt-5 max-w-2xl text-lg leading-relaxed text-slate-600">
                Partout à Bamako et dans toutes les régions du Mali — rapide, suivi, et payable à la livraison.
            </p>
            <div class="mt-9">
                <a href="{{ route('catalogue.index') }}"
                   class="group inline-flex items-center gap-2 rounded-full bg-furaso px-8 py-4 text-base font-semibold text-white shadow-soft transition-all duration-300 hover:-translate-y-0.5 hover:bg-furaso-dark hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-furaso/30">
                    Commander maintenant
                    <i data-lucide="arrow-right" class="h-5 w-5 transition-transform duration-300 group-hover:translate-x-1"></i>
                </a>
            </div>
        </div>
    </section>

    {{-- ========== 2. POURQUOI NOUS CHOISIR ========== --}}
    <section class="bg-white">
        <div class="mx-auto max-w-6xl px-6 py-20">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold text-slate-900 sm:text-4xl">Pourquoi nous choisir</h2>
                <p class="mt-3 text-slate-500">Une livraison pensée pour votre tranquillité.</p>
            </div>

            @php
                $avantages = [
                    ['icon' => 'zap',        'grad' => 'from-amber-400 to-orange-500',   'titre' => 'Livraison le jour même', 'texte' => '30 min à 3h sur Bamako selon votre quartier.'],
                    ['icon' => 'gift',       'grad' => 'from-emerald-400 to-furaso',     'titre' => 'Livraison gratuite',     'texte' => "Offerte dès " . number_format($seuilGratuit, 0, ',', ' ') . " FCFA d'achat."],
                    ['icon' => 'map-pin',    'grad' => 'from-sky-400 to-medical',        'titre' => 'Suivi en temps réel',   'texte' => "Suivez votre commande jusqu'à votre porte."],
                    ['icon' => 'banknote',   'grad' => 'from-rose-400 to-pink-500',      'titre' => 'Payez à la réception',  'texte' => 'Espèces, Orange Money ou Moov Money.'],
                ];
            @endphp

            <div class="mt-14 grid gap-7 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($avantages as $a)
                    <div class="group rounded-3xl border border-slate-100 bg-white p-7 text-center shadow-lg shadow-slate-200/60 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl">
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br {{ $a['grad'] }} text-white shadow-lg ring-4 ring-white transition-transform duration-300 group-hover:scale-110 group-hover:rotate-3">
                            <i data-lucide="{{ $a['icon'] }}" class="h-7 w-7"></i>
                        </div>
                        <h3 class="mt-5 text-lg font-bold text-slate-900">{{ $a['titre'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-500">{{ $a['texte'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ========== 3. PROCESSUS (timeline horizontale) ========== --}}
    <section class="bg-gradient-to-b from-emerald-50/60 to-white">
        <div class="mx-auto max-w-6xl px-6 py-20">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold text-slate-900 sm:text-4xl">Comment suivre ma livraison ?</h2>
                <p class="mt-3 text-slate-500">À chaque étape, vous recevez une notification.</p>
            </div>

            @php
                $etapes = [
                    ['num' => '1', 'icon' => 'check-circle', 'titre' => 'Confirmée',        'texte' => 'Votre commande est validée par la pharmacie.'],
                    ['num' => '2', 'icon' => 'package',      'titre' => 'En préparation',   'texte' => 'Vos médicaments sont rassemblés et vérifiés.'],
                    ['num' => '3', 'icon' => 'bike',         'titre' => 'Livreur en route', 'texte' => 'Le livreur part avec votre commande (nom et téléphone affichés).'],
                    ['num' => '4', 'icon' => 'home',         'titre' => 'Livrée',           'texte' => 'Vous recevez vos médicaments et payez à la réception.'],
                ];
            @endphp

            <div class="relative mt-16">
                {{-- ligne reliant les cercles (desktop) --}}
                <div class="absolute left-0 right-0 top-7 hidden lg:block">
                    <div class="mx-auto h-1 w-[78%] rounded-full bg-gradient-to-r from-furaso/30 via-furaso to-furaso/30"></div>
                </div>

                <div class="grid gap-12 sm:grid-cols-2 lg:grid-cols-4 lg:gap-6">
                    @foreach($etapes as $e)
                        <div class="relative flex flex-col items-center text-center">
                            <div class="relative z-10 flex h-14 w-14 items-center justify-center rounded-full bg-furaso text-lg font-bold text-white shadow-soft ring-4 ring-white">
                                {{ $e['num'] }}
                            </div>
                            <div class="mt-6 w-full rounded-3xl border border-slate-100 bg-white p-6 shadow-lg shadow-slate-200/60">
                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-furaso-light text-furaso-dark">
                                    <i data-lucide="{{ $e['icon'] }}" class="h-6 w-6"></i>
                                </div>
                                <h3 class="mt-4 text-base font-bold text-slate-900">{{ $e['titre'] }}</h3>
                                <p class="mt-2 text-sm leading-relaxed text-slate-500">{{ $e['texte'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ========== 4. TARIFS (cartes par zone) ========== --}}
    <section class="bg-white">
        <div class="mx-auto max-w-6xl px-6 py-20">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold text-slate-900 sm:text-4xl">Zones et tarifs de livraison</h2>
                <p class="mt-3 text-slate-500">Choisissez votre quartier au moment de la commande, les frais s'appliquent automatiquement.</p>
            </div>

            @php
                $parGroupe = [];
                foreach ($zones as $nom => $info) {
                    $parGroupe[$info['groupe']]['frais'] = $info['frais'];
                    $parGroupe[$info['groupe']]['delai'] = $info['delai'];
                    $quartier = trim(preg_replace('/\(.*\)/', '', $nom));
                    $parGroupe[$info['groupe']]['quartiers'][] = $quartier;
                }
            @endphp

            <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($parGroupe as $groupe => $info)
                    <div class="flex flex-col rounded-3xl border border-slate-100 bg-white p-6 shadow-lg shadow-slate-200/50 transition-all duration-300 hover:-translate-y-1 hover:border-furaso/30 hover:shadow-xl">
                        <div class="flex items-start justify-between gap-3">
                            <h3 class="text-lg font-extrabold text-slate-900">{{ $groupe }}</h3>
                            <span class="shrink-0 rounded-full bg-furaso-light px-3 py-1 text-sm font-bold text-furaso-dark">
                                {{ number_format($info['frais'], 0, ',', ' ') }} FCFA
                            </span>
                        </div>
                        <p class="mt-2 inline-flex items-center gap-1.5 text-sm font-medium text-medical">
                            <i data-lucide="clock" class="h-4 w-4"></i> {{ $info['delai'] }}
                        </p>
                        <div class="mt-4 flex flex-wrap gap-2">
                            @foreach($info['quartiers'] as $quartier)
                                <span class="rounded-lg bg-slate-50 px-2.5 py-1 text-xs font-medium text-slate-600 ring-1 ring-slate-100">{{ $quartier }}</span>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-10 flex items-start gap-3 rounded-2xl border border-furaso/20 bg-furaso-light/60 p-5 text-furaso-dark">
                <i data-lucide="lightbulb" class="mt-0.5 h-5 w-5 shrink-0"></i>
                <p class="text-sm leading-relaxed">
                    Livraison <strong>gratuite</strong> pour toute commande supérieure ou égale à
                    {{ number_format($seuilGratuit, 0, ',', ' ') }} FCFA, quelle que soit la zone.
                </p>
            </div>
        </div>
    </section>

    {{-- ========== 5. CRÉNEAUX ========== --}}
    <section class="bg-gradient-to-b from-white to-emerald-50/60">
        <div class="mx-auto max-w-6xl px-6 py-20">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold text-slate-900 sm:text-4xl">Créneaux de livraison</h2>
                <p class="mt-3 text-slate-500">Vous choisissez quand être livré.</p>
            </div>

            <div class="mt-12 grid gap-5 sm:grid-cols-2">
                @foreach($creneaux as $cle => $libelle)
                    <div class="flex items-center gap-4 rounded-2xl border border-slate-100 bg-white p-5 shadow-md shadow-slate-200/50 transition-all duration-300 hover:-translate-y-0.5 hover:border-furaso/30 hover:shadow-lg">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-400 to-furaso text-white shadow-md">
                            <i data-lucide="clock" class="h-6 w-6"></i>
                        </div>
                        <span class="font-semibold text-slate-800">{{ $libelle }}</span>
                    </div>
                @endforeach
            </div>

            <div class="mt-14 text-center">
                <a href="{{ route('catalogue.index') }}"
                   class="group inline-flex items-center gap-2 rounded-full bg-furaso px-8 py-4 text-base font-semibold text-white shadow-soft transition-all duration-300 hover:-translate-y-0.5 hover:bg-furaso-dark hover:shadow-xl">
                    Commander maintenant
                    <i data-lucide="arrow-right" class="h-5 w-5 transition-transform duration-300 group-hover:translate-x-1"></i>
                </a>
            </div>
        </div>
    </section>
</div>

{{-- (re)génère les icônes Lucide après le rendu Tailwind --}}
<script>window.lucide && lucide.createIcons();</script>
@endsection
