<?php

namespace App\Http\Controllers;

use App\Models\Avis;
use App\Models\Pharmacie;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AvisController extends Controller
{
    public function store(Request $request, Pharmacie $pharmacie): RedirectResponse
    {
        $data = $request->validate([
            'note' => ['required', 'integer', 'min:1', 'max:5'],
            'commentaire' => ['nullable', 'string', 'max:1000'],
        ]);

        Avis::updateOrCreate(
            ['user_id' => auth()->id(), 'pharmacie_id' => $pharmacie->id],
            ['note' => $data['note'], 'commentaire' => $data['commentaire'] ?? null],
        );

        return back()->with('success', 'Merci pour votre évaluation !');
    }
}
