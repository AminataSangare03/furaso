<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Ordonnance;
use App\Models\Pharmacie;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrdonnanceController extends Controller
{
    public function index(): View
    {
        $patient = auth()->user()->patient;

        return view('patient.ordonnances.index', [
            'ordonnances' => $patient ? $patient->ordonnances()->with('pharmacie')->paginate(10) : collect(),
        ]);
    }

    public function create(): View
    {
        return view('patient.ordonnances.create', [
            'pharmacies' => Pharmacie::where('partenaire', true)->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'fichier' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:8192'],
            'pharmacie_id' => ['nullable', 'exists:pharmacies,id'],
        ]);

        $patient = auth()->user()->patient;
        if (! $patient) {
            return back()->with('error', 'Profil patient introuvable.');
        }

        $file = $request->file('fichier');
        $type = $file->getClientOriginalExtension() === 'pdf' ? 'pdf' : 'image';
        $chemin = $file->store('ordonnances', 'public');

        $ordonnance = Ordonnance::create([
            'patient_id' => $patient->id,
            'pharmacie_id' => $request->input('pharmacie_id'),
            'fichier' => $chemin,
            'type' => $type,
            'statut' => 'en_attente',
            'date_envoi' => now(),
        ]);

        foreach (User::where('role', 'pharmacien')->pluck('id') as $pharmacienId) {
            NotificationService::envoyer($pharmacienId, 'Nouvelle ordonnance', "Une ordonnance #{$ordonnance->id} attend votre validation.");
        }

        return redirect()->route('patient.ordonnances.index')
            ->with('success', 'Ordonnance envoyée. Un pharmacien va la vérifier.');
    }

    public function show(Ordonnance $ordonnance): View
    {
        abort_unless((int) $ordonnance->patient->user_id === (int) auth()->id(), 403);

        return view('patient.ordonnances.show', compact('ordonnance'));
    }
}
