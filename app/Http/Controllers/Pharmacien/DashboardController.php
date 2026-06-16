<?php

namespace App\Http\Controllers\Pharmacien;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\DetailCommande;
use App\Models\Medicament;
use App\Models\Ordonnance;
use App\Models\Patient;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $chiffreAffaires = Commande::whereIn('statut', ['confirmee', 'preparee', 'expediee', 'livree'])
            ->sum('montant_total');

        $produitsPopulaires = DetailCommande::select('nom_medicament', DB::raw('SUM(quantite) as total'))
            ->groupBy('nom_medicament')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        return view('pharmacien.dashboard', [
            'nbMedicaments' => Medicament::count(),
            'nbStockFaible' => Medicament::where('stock', '<', 10)->count(),
            'nbOrdonnancesAttente' => Ordonnance::where('statut', 'en_attente')->count(),
            'nbCommandes' => Commande::count(),
            'nbCommandesAttente' => Commande::where('statut', 'en_attente')->count(),
            'nbPatients' => Patient::count(),
            'chiffreAffaires' => $chiffreAffaires,
            'produitsPopulaires' => $produitsPopulaires,
            'dernieresCommandes' => Commande::with('patient.user')->latest()->take(5)->get(),
            'dernieresOrdonnances' => Ordonnance::with('patient.user')->latest()->take(5)->get(),
        ]);
    }
}
