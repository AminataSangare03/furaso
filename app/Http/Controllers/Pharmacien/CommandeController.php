<?php

namespace App\Http\Controllers\Pharmacien;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Services\NotificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CommandeController extends Controller
{
    public function index(Request $request): View
    {
        $query = Commande::with('patient.user', 'livraison');

        if ($statut = $request->input('statut')) {
            $query->where('statut', $statut);
        }

        return view('pharmacien.commandes.index', [
            'commandes' => $query->latest()->paginate(15)->withQueryString(),
            'statut' => $statut,
        ]);
    }

    public function show(Commande $commande): View
    {
        $commande->load('details.medicament', 'patient.user', 'livraison', 'paiement', 'ordonnance');

        return view('pharmacien.commandes.show', compact('commande'));
    }

    public function updateStatut(Request $request, Commande $commande): RedirectResponse
    {
        $data = $request->validate([
            'statut' => ['required', 'in:en_attente,confirmee,preparee,expediee,livree,annulee'],
            'livreur' => ['nullable', 'string', 'max:255'],
            'livreur_telephone' => ['nullable', 'string', 'max:255'],
            'date_livraison_prevue' => ['nullable', 'date'],
        ]);

        $commande->update(['statut' => $data['statut']]);

        // Synchronise le statut de livraison.
        if ($commande->livraison) {
            $statutLivraison = match ($data['statut']) {
                'expediee' => 'en_cours',
                'livree' => 'livree',
                default => 'en_preparation',
            };
            $commande->livraison->update([
                'statut' => $statutLivraison,
                'livreur' => $data['livreur'] ?? $commande->livraison->livreur,
                'livreur_telephone' => $data['livreur_telephone'] ?? $commande->livraison->livreur_telephone,
                'date_livraison_prevue' => $data['date_livraison_prevue'] ?? $commande->livraison->date_livraison_prevue,
                'date_livraison' => $data['statut'] === 'livree' ? now() : $commande->livraison->date_livraison,
            ]);
        }

        if ($data['statut'] === 'livree' && $commande->paiement && $commande->mode_paiement === 'livraison') {
            $commande->paiement->update(['statut' => 'paye']);
        }

        NotificationService::envoyer(
            $commande->patient->user_id,
            'Mise à jour de commande',
            "Votre commande #{$commande->id} est désormais : {$commande->statutLibelle()}.",
            route('patient.commandes.show', $commande)
        );

        return back()->with('success', 'Statut de la commande mis à jour.');
    }
}
