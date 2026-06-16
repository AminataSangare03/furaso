<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use Illuminate\View\View;

class CommandeController extends Controller
{
    public function index(): View
    {
        $patient = auth()->user()->patient;

        return view('patient.commandes.index', [
            'commandes' => $patient
                ? $patient->commandes()->with('details', 'livraison', 'paiement')->paginate(10)
                : collect(),
        ]);
    }

    public function show(Commande $commande): View
    {
        abort_unless((int) $commande->patient->user_id === (int) auth()->id(), 403);

        $commande->load('details.medicament', 'livraison', 'paiement', 'pharmacie', 'ordonnance');

        return view('patient.commandes.show', compact('commande'));
    }
}
