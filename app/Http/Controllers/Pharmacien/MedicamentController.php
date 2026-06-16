<?php

namespace App\Http\Controllers\Pharmacien;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Medicament;
use App\Models\Pharmacie;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MedicamentController extends Controller
{
    public function index(Request $request): View
    {
        $query = Medicament::with('categorie', 'pharmacie');

        if ($q = $request->string('q')->trim()->value()) {
            $query->where('nom', 'like', "%{$q}%");
        }

        return view('pharmacien.medicaments.index', [
            'medicaments' => $query->orderBy('nom')->paginate(15)->withQueryString(),
        ]);
    }

    public function create(): View
    {
        return view('pharmacien.medicaments.form', [
            'medicament' => new Medicament,
            'categories' => Categorie::orderBy('nom')->get(),
            'pharmacies' => Pharmacie::all(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->valider($request);
        $data['image'] = $this->image($request);

        Medicament::create($data);

        return redirect()->route('pharmacien.medicaments.index')
            ->with('success', 'Médicament ajouté.');
    }

    public function edit(Medicament $medicament): View
    {
        return view('pharmacien.medicaments.form', [
            'medicament' => $medicament,
            'categories' => Categorie::orderBy('nom')->get(),
            'pharmacies' => Pharmacie::all(),
        ]);
    }

    public function update(Request $request, Medicament $medicament): RedirectResponse
    {
        $data = $this->valider($request);

        if ($image = $this->image($request)) {
            if ($medicament->image) {
                Storage::disk('public')->delete($medicament->image);
            }
            $data['image'] = $image;
        }

        $medicament->update($data);

        return redirect()->route('pharmacien.medicaments.index')
            ->with('success', 'Médicament mis à jour.');
    }

    public function destroy(Medicament $medicament): RedirectResponse
    {
        if ($medicament->image) {
            Storage::disk('public')->delete($medicament->image);
        }
        $medicament->delete();

        return back()->with('success', 'Médicament supprimé.');
    }

    private function valider(Request $request): array
    {
        return $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'categorie_id' => ['nullable', 'exists:categories,id'],
            'pharmacie_id' => ['nullable', 'exists:pharmacies,id'],
            'description' => ['nullable', 'string'],
            'dosage' => ['nullable', 'string', 'max:255'],
            'laboratoire' => ['nullable', 'string', 'max:255'],
            'prix' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'ordonnance_obligatoire' => ['nullable', 'boolean'],
            'effets_secondaires' => ['nullable', 'string'],
            'conseils_utilisation' => ['nullable', 'string'],
            'maladie' => ['nullable', 'string', 'max:255'],
            'date_expiration' => ['nullable', 'date'],
        ]) + ['ordonnance_obligatoire' => $request->boolean('ordonnance_obligatoire')];
    }

    private function image(Request $request): ?string
    {
        $request->validate(['image' => ['nullable', 'image', 'max:4096']]);

        return $request->hasFile('image')
            ? $request->file('image')->store('medicaments', 'public')
            : null;
    }
}
