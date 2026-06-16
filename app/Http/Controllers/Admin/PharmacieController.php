<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pharmacie;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PharmacieController extends Controller
{
    public function index(): View
    {
        return view('admin.pharmacies.index', [
            'pharmacies' => Pharmacie::withCount('medicaments', 'pharmaciens')->orderBy('nom')->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.pharmacies.form', ['pharmacie' => new Pharmacie]);
    }

    public function store(Request $request): RedirectResponse
    {
        Pharmacie::create($this->valider($request));

        return redirect()->route('admin.pharmacies.index')->with('success', 'Pharmacie ajoutée.');
    }

    public function edit(Pharmacie $pharmacie): View
    {
        return view('admin.pharmacies.form', compact('pharmacie'));
    }

    public function update(Request $request, Pharmacie $pharmacie): RedirectResponse
    {
        $pharmacie->update($this->valider($request));

        return redirect()->route('admin.pharmacies.index')->with('success', 'Pharmacie mise à jour.');
    }

    public function destroy(Pharmacie $pharmacie): RedirectResponse
    {
        $pharmacie->delete();

        return back()->with('success', 'Pharmacie supprimée.');
    }

    private function valider(Request $request): array
    {
        return $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'adresse' => ['nullable', 'string', 'max:255'],
            'telephone' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'ville' => ['nullable', 'string', 'max:255'],
            'region' => ['nullable', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'partenaire' => ['nullable', 'boolean'],
        ]) + ['partenaire' => $request->boolean('partenaire')];
    }
}
