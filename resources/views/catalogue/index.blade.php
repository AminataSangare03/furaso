@extends('layouts.app')
@section('title', 'Catalogue des médicaments — Furaso')

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

@php
    $catActive = (int) ($filtres['categorie'] ?? 0);
    $triActuel = $filtres['tri'] ?? 'nom';
    // paramètres courants (sans la pagination) pour préserver les filtres dans les liens
    $base = collect(request()->except(['page']));
@endphp

<div class="tw-catalogue font-sans text-slate-700 antialiased [&_h1]:m-0 [&_h2]:m-0 [&_h3]:m-0 [&_p]:m-0 [&_label]:m-0">

    {{-- ========== 1. HÉROS + RECHERCHE ========== --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-furaso-light via-emerald-50 to-white">
        <div class="pointer-events-none absolute -top-24 -right-24 h-72 w-72 rounded-full bg-furaso/20 blur-3xl"></div>
        <div class="pointer-events-none absolute inset-0 opacity-[0.06]"
             style="background-image:radial-gradient(#16A34A 1.4px, transparent 1.4px);background-size:26px 26px;"></div>

        <div class="relative mx-auto max-w-7xl px-6 py-16 sm:py-20 text-center">
            <h1 class="text-4xl font-extrabold tracking-tight text-slate-900 sm:text-5xl">Catalogue des médicaments</h1>
            <p class="mx-auto mt-4 max-w-2xl text-lg text-slate-600">Trouvez vos médicaments avec ou sans ordonnance, livrés chez vous.</p>

            <form method="GET" action="{{ route('catalogue.index') }}" class="mx-auto mt-9 flex max-w-3xl flex-col gap-3 sm:flex-row">
                @foreach($base->except(['q']) as $k => $v)
                    <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                @endforeach
                <div class="relative flex-1">
                    <i data-lucide="search" class="pointer-events-none absolute left-5 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="q" value="{{ $filtres['q'] ?? '' }}"
                           placeholder="Rechercher un médicament (ex: Paracétamol)..."
                           class="w-full rounded-full border border-slate-200 bg-white/90 py-4 pl-14 pr-5 text-base shadow-lg shadow-slate-200/60 outline-none transition focus:border-furaso focus:ring-4 focus:ring-furaso/20">
                </div>
                <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-full border-2 border-furaso bg-white px-7 py-4 text-base font-semibold text-furaso-dark transition hover:bg-furaso hover:text-white">
                    <i data-lucide="search" class="h-5 w-5"></i> Rechercher
                </button>
            </form>
        </div>
    </section>

    <div class="mx-auto max-w-7xl px-6 py-12">

        {{-- ========== 2. BARRE DE TRI ========== --}}
        <div class="mb-8 flex flex-col items-start justify-between gap-4 border-b border-slate-200 pb-5 sm:flex-row sm:items-center">
            <p class="text-sm font-medium text-slate-500">{{ $medicaments->total() }} médicament(s) trouvé(s)</p>
            <form method="GET" action="{{ route('catalogue.index') }}" class="flex items-center gap-3">
                @foreach($base->except(['tri']) as $k => $v)
                    <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                @endforeach
                <label class="text-sm font-medium text-slate-500">Trier par :</label>
                <div class="relative">
                    <select name="tri" onchange="this.form.submit()"
                            class="appearance-none rounded-xl border border-slate-200 bg-white py-2.5 pl-4 pr-10 text-sm font-semibold text-slate-700 shadow-sm outline-none transition focus:border-furaso focus:ring-2 focus:ring-furaso/20">
                        <option value="nom" @selected($triActuel === 'nom')>Nom</option>
                        <option value="prix_asc" @selected($triActuel === 'prix_asc')>Prix croissant</option>
                        <option value="prix_desc" @selected($triActuel === 'prix_desc')>Prix décroissant</option>
                    </select>
                    <i data-lucide="chevron-down" class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-[280px_1fr]">

            {{-- ========== 3. SIDEBAR DE FILTRES ========== --}}
            <aside class="h-fit rounded-2xl bg-white p-8 shadow-lg shadow-slate-200/60 ring-1 ring-slate-100 lg:sticky lg:top-6">
                {{-- Catégories en chips --}}
                <div>
                    <h3 class="mb-4 text-sm font-bold uppercase tracking-wide text-slate-400">Catégorie</h3>
                    <div class="flex flex-wrap gap-2">
                        @php($urlToutes = route('catalogue.index') . '?' . http_build_query($base->except(['categorie', 'page'])->toArray()))
                        <a href="{{ $urlToutes }}"
                           class="rounded-full px-3.5 py-1.5 text-sm font-medium transition {{ $catActive === 0 ? 'bg-furaso text-white shadow' : 'bg-slate-100 text-slate-600 hover:bg-furaso-light hover:text-furaso-dark' }}">
                            Toutes
                        </a>
                        @foreach($categories as $cat)
                            @php($urlCat = route('catalogue.index') . '?' . http_build_query(array_merge($base->except(['categorie', 'page'])->toArray(), ['categorie' => $cat->id])))
                            <a href="{{ $urlCat }}"
                               class="rounded-full px-3.5 py-1.5 text-sm font-medium transition {{ $catActive === $cat->id ? 'bg-furaso text-white shadow' : 'bg-slate-100 text-slate-600 hover:bg-furaso-light hover:text-furaso-dark' }}">
                                {{ $cat->nom }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <form method="GET" action="{{ route('catalogue.index') }}" class="mt-7 space-y-6">
                    <input type="hidden" name="q" value="{{ $filtres['q'] ?? '' }}">
                    <input type="hidden" name="categorie" value="{{ $filtres['categorie'] ?? '' }}">
                    <input type="hidden" name="tri" value="{{ $triActuel }}">

                    {{-- Prix maximum --}}
                    <div>
                        <label class="mb-2 block text-sm font-bold uppercase tracking-wide text-slate-400">Prix maximum (FCFA)</label>
                        <input type="number" name="prix_max" value="{{ $filtres['prix_max'] ?? '' }}" min="0" placeholder="ex : 5000"
                               class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm outline-none transition focus:border-furaso focus:ring-2 focus:ring-furaso/20">
                    </div>

                    {{-- Ordonnance --}}
                    <div>
                        <label class="mb-2 block text-sm font-bold uppercase tracking-wide text-slate-400">Ordonnance</label>
                        <div class="relative">
                            <select name="ordonnance"
                                    class="w-full appearance-none rounded-xl border border-slate-200 bg-white py-2.5 pl-4 pr-10 text-sm font-medium text-slate-700 outline-none transition focus:border-furaso focus:ring-2 focus:ring-furaso/20">
                                <option value="">Tous</option>
                                <option value="0" @selected(($filtres['ordonnance'] ?? null) === '0')>Sans ordonnance</option>
                                <option value="1" @selected(($filtres['ordonnance'] ?? null) === '1')>Sur ordonnance</option>
                            </select>
                            <i data-lucide="chevron-down" class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>
                        </div>
                    </div>

                    {{-- En stock uniquement (toggle) --}}
                    <label class="flex cursor-pointer items-center justify-between">
                        <span class="text-sm font-medium text-slate-600">En stock uniquement</span>
                        <span class="relative inline-flex">
                            <input type="checkbox" name="disponible" value="1" class="peer sr-only" @checked(! empty($filtres['disponible']))>
                            <span class="h-6 w-11 rounded-full bg-slate-200 transition-colors peer-checked:bg-furaso"></span>
                            <span class="absolute left-0.5 top-0.5 h-5 w-5 rounded-full bg-white shadow transition-transform peer-checked:translate-x-5"></span>
                        </span>
                    </label>

                    {{-- Boutons --}}
                    <div class="flex flex-col gap-3 pt-2">
                        <button type="submit"
                                class="w-full rounded-xl bg-furaso px-5 py-3 text-sm font-semibold text-white shadow-soft transition hover:-translate-y-0.5 hover:bg-furaso-dark">
                            Appliquer
                        </button>
                        <a href="{{ route('catalogue.index') }}"
                           class="w-full rounded-xl border border-slate-200 px-5 py-3 text-center text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                            Réinitialiser
                        </a>
                    </div>
                </form>
            </aside>

            {{-- ========== 4. GRILLE DE PRODUITS ========== --}}
            <div>
                @if($medicaments->isEmpty())
                    <div class="flex flex-col items-center justify-center rounded-3xl bg-white p-16 text-center shadow-lg shadow-slate-200/60">
                        <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-furaso-light text-furaso">
                            <i class="fa-solid fa-pills text-2xl"></i>
                        </div>
                        <p class="mt-5 text-slate-500">Aucun médicament ne correspond à votre recherche.</p>
                    </div>
                @else
                    <div class="grid grid-cols-2 gap-5 md:grid-cols-3 xl:grid-cols-4">
                        @foreach($medicaments as $med)
                            <div class="group relative flex flex-col overflow-hidden rounded-2xl bg-white shadow-lg shadow-slate-200/60 ring-1 ring-slate-100 transition-all duration-300 hover:-translate-y-1.5 hover:shadow-2xl">
                                {{-- Image --}}
                                <a href="{{ route('catalogue.show', $med) }}" class="relative block aspect-square overflow-hidden bg-gradient-to-br from-slate-50 to-emerald-50/50">
                                    @if($med->image)
                                        <img src="{{ asset('storage/' . $med->image) }}" alt="{{ $med->nom }}"
                                             class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                                    @else
                                        <span class="flex h-full w-full items-center justify-center text-furaso/40">
                                            <i class="fa-solid fa-pills text-5xl"></i>
                                        </span>
                                    @endif
                                    @if($med->ordonnance_obligatoire)
                                        <span class="absolute left-3 top-3 rounded-full bg-medical-light px-2.5 py-1 text-xs font-bold text-medical">Sur ordonnance</span>
                                    @endif
                                    @if($med->stock <= 0)
                                        <span class="absolute right-3 top-3 rounded-full bg-rose-100 px-2.5 py-1 text-xs font-bold text-rose-600">Rupture</span>
                                    @endif
                                </a>

                                {{-- Corps --}}
                                <div class="flex flex-1 flex-col p-4">
                                    <a href="{{ route('catalogue.show', $med) }}" class="text-base font-bold leading-snug text-slate-900 hover:text-furaso-dark">{{ $med->nom }}</a>
                                    <p class="mt-1 text-xs text-slate-400">{{ $med->laboratoire ?: 'Laboratoire générique' }}@if($med->dosage) · {{ $med->dosage }}@endif</p>

                                    <div class="mt-auto flex items-end justify-between pt-4">
                                        <span class="text-lg font-extrabold text-furaso">{{ number_format($med->prix, 0, ',', ' ') }} <span class="text-xs font-semibold text-furaso/70">FCFA</span></span>
                                        @if($med->stock > 0 && ! $med->ordonnance_obligatoire)
                                            <form method="POST" action="{{ route('panier.ajouter', $med) }}">
                                                @csrf
                                                <button type="submit" title="Ajouter au panier"
                                                        class="flex h-10 w-10 items-center justify-center rounded-full bg-furaso text-white shadow-md transition hover:scale-110 hover:bg-furaso-dark">
                                                    <i data-lucide="plus" class="h-5 w-5"></i>
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('catalogue.show', $med) }}" title="Voir le détail"
                                               class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 text-slate-500 transition hover:bg-slate-200">
                                                <i data-lucide="eye" class="h-5 w-5"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-10">{{ $medicaments->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- (re)génère les icônes Lucide après le rendu Tailwind --}}
<script>window.lucide && lucide.createIcons();</script>
@endsection
