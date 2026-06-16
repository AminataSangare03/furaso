<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Medicament;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogueController extends Controller
{
    public function index(Request $request): View
    {
        $query = Medicament::query()->with('categorie', 'pharmacie');

        if ($recherche = $request->string('q')->trim()->value()) {
            $query->where(function ($q) use ($recherche) {
                $q->where('nom', 'like', "%{$recherche}%")
                    ->orWhere('laboratoire', 'like', "%{$recherche}%")
                    ->orWhere('maladie', 'like', "%{$recherche}%")
                    ->orWhere('description', 'like', "%{$recherche}%");
            });
        }

        if ($categorie = $request->integer('categorie')) {
            $query->where('categorie_id', $categorie);
        }

        if ($request->filled('ordonnance')) {
            $query->where('ordonnance_obligatoire', $request->input('ordonnance') === '1');
        }

        if ($request->boolean('disponible')) {
            $query->where('stock', '>', 0);
        }

        if ($prixMax = $request->integer('prix_max')) {
            $query->where('prix', '<=', $prixMax);
        }

        $tri = $request->input('tri', 'nom');
        match ($tri) {
            'prix_asc' => $query->orderBy('prix'),
            'prix_desc' => $query->orderByDesc('prix'),
            default => $query->orderBy('nom'),
        };

        return view('catalogue.index', [
            'medicaments' => $query->paginate(12)->withQueryString(),
            'categories' => Categorie::orderBy('nom')->get(),
            'filtres' => $request->all(),
        ]);
    }

    public function show(Medicament $medicament): View
    {
        $medicament->load('categorie', 'pharmacie');

        $similaires = Medicament::where('categorie_id', $medicament->categorie_id)
            ->where('id', '!=', $medicament->id)
            ->take(4)->get();

        return view('catalogue.show', compact('medicament', 'similaires'));
    }
}
