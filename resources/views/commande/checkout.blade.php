@extends('layouts.app')
@section('title', 'Finaliser la commande — Furaso')

@section('content')
<section class="section">
    <div class="container">
        <h1 class="mb">Finaliser ma commande</h1>
        <form method="POST" action="{{ route('patient.checkout.store') }}">
            @csrf
            <div class="grid" style="grid-template-columns:2fr 1fr;gap:24px">
                <div>
                    <div class="card card-pad mb">
                        <h3 class="mb">Livraison</h3>
                        <div class="form-group">
                            <label>Zone de livraison</label>
                            <select name="zone_livraison" id="zone" required>
                                <option value="">— Choisir une zone —</option>
                                @php($groupe = null)
                                @foreach($zones as $nom => $info)
                                    @if($groupe !== $info['groupe'])
                                        @if($groupe !== null)</optgroup>@endif
                                        <optgroup label="{{ $info['groupe'] }}">
                                        @php($groupe = $info['groupe'])
                                    @endif
                                    <option value="{{ $nom }}" data-frais="{{ $info['frais'] }}" data-delai="{{ $info['delai'] }}" @selected(old('zone_livraison')===$nom)>{{ $nom }} — {{ number_format($info['frais'],0,',',' ') }} FCFA ({{ $info['delai'] }})</option>
                                @endforeach
                                </optgroup>
                            </select>
                        </div>
                        @if($total < $seuilGratuit)
                            <p class="help mb"><i data-lucide="truck"></i> Livraison <strong>offerte</strong> dès {{ number_format($seuilGratuit,0,',',' ') }} FCFA d'achat (il vous manque {{ number_format($seuilGratuit - $total,0,',',' ') }} FCFA).</p>
                        @else
                            <div class="alert alert-success mb"><i data-lucide="party-popper"></i> Votre livraison est <strong>gratuite</strong> !</div>
                        @endif
                        <div class="form-group">
                            <label>Créneau de livraison</label>
                            <select name="creneau" required>
                                @foreach($creneaux as $cle => $libelle)
                                    <option value="{{ $cle }}" @selected(old('creneau')===$cle || ($loop->first && ! old('creneau')))>{{ $libelle }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Adresse de livraison</label>
                            <input type="text" name="adresse_livraison" value="{{ old('adresse_livraison', trim(($user->adresse ?? '').' '.($user->quartier ?? ''))) }}" placeholder="Rue, quartier, point de repère" required>
                        </div>
                    </div>

                    <div class="card card-pad mb">
                        <h3 class="mb">Mode de paiement</h3>
                        @foreach($modesPaiement as $cle => $libelle)
                            <label style="font-weight:400;display:flex;gap:10px;align-items:center;padding:10px;border:1px solid var(--gris-clair);border-radius:9px;margin-bottom:8px;cursor:pointer">
                                <input type="radio" name="mode_paiement" value="{{ $cle }}" style="width:auto" @checked(old('mode_paiement')===$cle || ($loop->first && ! old('mode_paiement'))) required>
                                {{ $libelle }}
                            </label>
                        @endforeach
                    </div>

                    @if($contientOrdonnance)
                        <div class="card card-pad mb">
                            <h3 class="mb">Ordonnance</h3>
                            <p class="help mb">Votre panier contient des médicaments sous ordonnance. Sélectionnez une ordonnance validée.</p>
                            @if($ordonnancesValidees->isEmpty())
                                <div class="alert alert-error">Vous n'avez aucune ordonnance validée. <a href="{{ route('patient.ordonnances.create') }}">Envoyez-en une</a> avant de commander.</div>
                            @else
                                <div class="form-group">
                                    <select name="ordonnance_id" required>
                                        <option value="">— Choisir une ordonnance validée —</option>
                                        @foreach($ordonnancesValidees as $ord)
                                            <option value="{{ $ord->id }}" @selected(old('ordonnance_id')==$ord->id)>Ordonnance #{{ $ord->id }} (validée le {{ $ord->updated_at->format('d/m/Y') }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                        </div>
                    @endif

                    <div class="card card-pad">
                        <h3 class="mb">Pharmacie (optionnel)</h3>
                        <select name="pharmacie_id">
                            <option value="">— Laisser Furaso choisir —</option>
                            @foreach($pharmacies as $ph)
                                <option value="{{ $ph->id }}" @selected(old('pharmacie_id')==$ph->id)>{{ $ph->nom }} ({{ $ph->ville }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="card card-pad" style="align-self:start">
                    <h3 class="mb">Récapitulatif</h3>
                    @foreach($lignes as $ligne)
                        <div class="flex between mb"><span class="muted">{{ $ligne['medicament']->nom }} ×{{ $ligne['quantite'] }}</span><span>{{ number_format($ligne['sous_total'],0,',',' ') }}</span></div>
                    @endforeach
                    <hr style="border:none;border-top:1px solid var(--gris-clair);margin:10px 0">
                    <div class="flex between mb"><span class="muted">Sous-total</span><strong>{{ number_format($total,0,',',' ') }} FCFA</strong></div>
                    <div class="flex between mb"><span class="muted">Frais de livraison</span><strong id="frais">— FCFA</strong></div>
                    <div class="flex between mb"><span class="muted">Délai estimé</span><span id="delai" class="muted">—</span></div>
                    <hr style="border:none;border-top:1px solid var(--gris-clair);margin:10px 0">
                    <div class="flex between mb"><span><strong>Total</strong></span><strong id="total" style="color:var(--vert);font-size:1.3rem">{{ number_format($total,0,',',' ') }} FCFA</strong></div>
                    <button class="btn btn-primary btn-block" type="submit">Confirmer la commande</button>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
    const base = {{ (int) $total }};
    const seuil = {{ (int) $seuilGratuit }};
    const zone = document.getElementById('zone');
    function maj() {
        const opt = zone.options[zone.selectedIndex];
        let frais = parseInt(opt.dataset.frais || 0);
        const delai = opt.dataset.delai || '—';
        if (base >= seuil) frais = 0;
        document.getElementById('frais').textContent = frais === 0 ? 'Gratuite' : frais.toLocaleString('fr-FR') + ' FCFA';
        document.getElementById('delai').textContent = delai;
        document.getElementById('total').textContent = (base + frais).toLocaleString('fr-FR') + ' FCFA';
    }
    zone.addEventListener('change', maj);
    if (zone.value) maj();
</script>
@endsection
