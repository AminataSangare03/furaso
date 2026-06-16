<div class="card produit">
    <div class="thumb">
        @if($med->image)
            <img src="{{ asset('storage/'.$med->image) }}" alt="{{ $med->nom }}">
        @else
            <i class="fa-solid fa-pills"></i>
        @endif
    </div>
    <div class="body">
        <div class="flex between center">
            <span class="nom">{{ $med->nom }}</span>
            @if($med->ordonnance_obligatoire)
                <span class="pill pill-blue" title="Sur ordonnance">Rx</span>
            @endif
        </div>
        <span class="lab">{{ $med->laboratoire ?: 'Laboratoire générique' }} @if($med->dosage)· {{ $med->dosage }}@endif</span>
        @if($med->stock > 0)
            <span class="pill pill-green" style="align-self:flex-start">En stock</span>
        @else
            <span class="pill pill-red" style="align-self:flex-start">Rupture</span>
        @endif
        <span class="prix">{{ number_format($med->prix, 0, ',', ' ') }} FCFA</span>
        <a href="{{ route('catalogue.show', $med) }}" class="btn btn-outline btn-sm btn-block">Voir le détail</a>
        @if($med->stock > 0 && ! $med->ordonnance_obligatoire)
            <form method="POST" action="{{ route('panier.ajouter', $med) }}">
                @csrf
                <button class="btn btn-primary btn-sm btn-block" type="submit"><i data-lucide="shopping-cart"></i> Ajouter</button>
            </form>
        @endif
    </div>
</div>
