<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\DetailCommande;
use App\Models\Livraison;
use App\Models\Paiement;
use App\Models\Pharmacie;
use App\Models\User;
use App\Services\LivraisonService;
use App\Services\NotificationService;
use App\Services\PanierService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CommandeController extends Controller
{
    public function __construct(private readonly PanierService $panier) {}

    public function checkout(): View|RedirectResponse
    {
        $lignes = $this->panier->lignes();

        if ($lignes->isEmpty()) {
            return redirect()->route('panier.index')->with('error', 'Votre panier est vide.');
        }

        $user = auth()->user();
        $patient = $user->patient;

        $ordonnancesValidees = $patient
            ? $patient->ordonnances()->where('statut', 'validee')->get()
            : collect();

        return view('commande.checkout', [
            'lignes' => $lignes,
            'total' => $this->panier->total(),
            'contientOrdonnance' => $this->panier->contientOrdonnance(),
            'zones' => LivraisonService::zones(),
            'modesPaiement' => LivraisonService::modesPaiement(),
            'ordonnancesValidees' => $ordonnancesValidees,
            'pharmacies' => Pharmacie::where('partenaire', true)->get(),
            'user' => $user,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $lignes = $this->panier->lignes();
        if ($lignes->isEmpty()) {
            return redirect()->route('panier.index')->with('error', 'Votre panier est vide.');
        }

        $data = $request->validate([
            'zone_livraison' => ['required', 'string'],
            'adresse_livraison' => ['required', 'string', 'max:255'],
            'mode_paiement' => ['required', 'in:livraison,orange_money,moov_money,carte'],
            'pharmacie_id' => ['nullable', 'exists:pharmacies,id'],
            'ordonnance_id' => ['nullable', 'exists:ordonnances,id'],
        ]);

        $patient = auth()->user()->patient;
        if (! $patient) {
            return back()->with('error', 'Seuls les patients peuvent passer commande.');
        }

        if ($this->panier->contientOrdonnance() && empty($data['ordonnance_id'])) {
            return back()->with('error', 'Votre panier contient des médicaments sous ordonnance. Sélectionnez une ordonnance validée.')->withInput();
        }

        $frais = LivraisonService::fraisPour($data['zone_livraison']);
        $total = $this->panier->total();

        $commande = DB::transaction(function () use ($lignes, $patient, $data, $frais, $total) {
            $commande = Commande::create([
                'patient_id' => $patient->id,
                'pharmacie_id' => $data['pharmacie_id'] ?? null,
                'ordonnance_id' => $data['ordonnance_id'] ?? null,
                'montant_total' => $total + $frais,
                'frais_livraison' => $frais,
                'statut' => 'en_attente',
                'mode_paiement' => $data['mode_paiement'],
                'adresse_livraison' => $data['adresse_livraison'],
                'zone_livraison' => $data['zone_livraison'],
            ]);

            foreach ($lignes as $ligne) {
                $medicament = $ligne['medicament'];
                DetailCommande::create([
                    'commande_id' => $commande->id,
                    'medicament_id' => $medicament->id,
                    'nom_medicament' => $medicament->nom,
                    'quantite' => $ligne['quantite'],
                    'prix' => $medicament->prix,
                ]);
                $medicament->decrement('stock', min($ligne['quantite'], $medicament->stock));
            }

            Paiement::create([
                'commande_id' => $commande->id,
                'montant' => $total + $frais,
                'methode' => $data['mode_paiement'],
                'statut' => $data['mode_paiement'] === 'livraison' ? 'en_attente' : 'en_attente',
                'reference' => strtoupper('PAY-'.uniqid()),
            ]);

            Livraison::create([
                'commande_id' => $commande->id,
                'zone' => $data['zone_livraison'],
                'frais' => $frais,
                'statut' => 'en_preparation',
            ]);

            return $commande;
        });

        $this->panier->vider();

        NotificationService::envoyer($patient->user_id, 'Commande enregistrée', "Votre commande #{$commande->id} a bien été enregistrée.", route('patient.commandes.show', $commande));

        // Notifie les pharmaciens concernés.
        $pharmaciens = User::where('role', 'pharmacien')->pluck('id');
        foreach ($pharmaciens as $pharmacienId) {
            NotificationService::envoyer($pharmacienId, 'Nouvelle commande', "Une nouvelle commande #{$commande->id} a été passée.");
        }

        return redirect()->route('patient.commandes.show', $commande)
            ->with('success', 'Votre commande a été passée avec succès !');
    }
}
