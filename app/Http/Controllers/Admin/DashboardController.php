<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\Medicament;
use App\Models\Paiement;
use App\Models\Pharmacie;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'nbUsers' => User::count(),
            'nbPatients' => User::where('role', 'patient')->count(),
            'nbPharmaciens' => User::where('role', 'pharmacien')->count(),
            'nbPharmacies' => Pharmacie::count(),
            'nbMedicaments' => Medicament::count(),
            'nbCommandes' => Commande::count(),
            'chiffreAffaires' => Commande::whereIn('statut', ['confirmee', 'preparee', 'expediee', 'livree'])->sum('montant_total'),
            'paiementsPayes' => Paiement::where('statut', 'paye')->sum('montant'),
            'dernieresCommandes' => Commande::with('patient.user')->latest()->take(8)->get(),
            'derniersUsers' => User::latest()->take(8)->get(),
        ]);
    }
}
