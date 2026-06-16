<?php

namespace App\Http\Controllers;

use App\Models\Medicament;
use App\Services\PanierService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PanierController extends Controller
{
    public function __construct(private readonly PanierService $panier) {}

    public function index(): View
    {
        return view('panier.index', [
            'lignes' => $this->panier->lignes(),
            'total' => $this->panier->total(),
            'contientOrdonnance' => $this->panier->contientOrdonnance(),
        ]);
    }

    public function ajouter(Request $request, Medicament $medicament): RedirectResponse
    {
        $quantite = max(1, (int) $request->input('quantite', 1));

        if ($medicament->stock <= 0) {
            return back()->with('error', 'Ce médicament est en rupture de stock.');
        }

        $this->panier->ajouter($medicament->id, $quantite);

        return back()->with('success', $medicament->nom.' ajouté au panier.');
    }

    public function modifier(Request $request, Medicament $medicament): RedirectResponse
    {
        $this->panier->modifier($medicament->id, (int) $request->input('quantite', 1));

        return back()->with('success', 'Panier mis à jour.');
    }

    public function supprimer(Medicament $medicament): RedirectResponse
    {
        $this->panier->supprimer($medicament->id);

        return back()->with('success', 'Produit retiré du panier.');
    }

    public function vider(): RedirectResponse
    {
        $this->panier->vider();

        return back()->with('success', 'Panier vidé.');
    }
}
