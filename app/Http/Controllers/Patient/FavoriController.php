<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Favori;
use App\Models\Medicament;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FavoriController extends Controller
{
    public function index(): View
    {
        $favoris = auth()->user()->favoris()->with('medicament.categorie')->get()
            ->pluck('medicament')->filter();

        return view('patient.favoris', compact('favoris'));
    }

    public function toggle(Medicament $medicament): RedirectResponse
    {
        $favori = Favori::where('user_id', auth()->id())
            ->where('medicament_id', $medicament->id)
            ->first();

        if ($favori) {
            $favori->delete();
            $message = 'Retiré de vos favoris.';
        } else {
            Favori::create([
                'user_id' => auth()->id(),
                'medicament_id' => $medicament->id,
            ]);
            $message = 'Ajouté à vos favoris.';
        }

        return back()->with('success', $message);
    }
}
