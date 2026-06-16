<?php

namespace App\Http\Controllers\Pharmacien;

use App\Http\Controllers\Controller;
use App\Models\Ordonnance;
use App\Services\NotificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrdonnanceController extends Controller
{
    public function index(Request $request): View
    {
        $query = Ordonnance::with('patient.user', 'pharmacie');

        if ($statut = $request->input('statut')) {
            $query->where('statut', $statut);
        }

        return view('pharmacien.ordonnances.index', [
            'ordonnances' => $query->latest()->paginate(15)->withQueryString(),
            'statut' => $statut,
        ]);
    }

    public function show(Ordonnance $ordonnance): View
    {
        $ordonnance->load('patient.user', 'pharmacie');

        return view('pharmacien.ordonnances.show', compact('ordonnance'));
    }

    public function valider(Request $request, Ordonnance $ordonnance): RedirectResponse
    {
        $data = $request->validate([
            'statut' => ['required', 'in:validee,refusee'],
            'commentaire_pharmacien' => ['nullable', 'string', 'max:1000'],
        ]);

        $ordonnance->update($data);

        $titre = $data['statut'] === 'validee' ? 'Ordonnance validée' : 'Ordonnance refusée';
        NotificationService::envoyer(
            $ordonnance->patient->user_id,
            $titre,
            $data['commentaire_pharmacien'] ?? "Votre ordonnance #{$ordonnance->id} a été traitée.",
            route('patient.ordonnances.show', $ordonnance)
        );

        return redirect()->route('pharmacien.ordonnances.index')
            ->with('success', 'Ordonnance traitée.');
    }
}
