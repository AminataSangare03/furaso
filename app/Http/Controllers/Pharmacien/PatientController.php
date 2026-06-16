<?php

namespace App\Http\Controllers\Pharmacien;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PatientController extends Controller
{
    public function index(Request $request): View
    {
        $query = Patient::with('user')->withCount('commandes', 'ordonnances');

        if ($q = $request->string('q')->trim()->value()) {
            $query->whereHas('user', function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('prenom', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            });
        }

        return view('pharmacien.patients.index', [
            'patients' => $query->paginate(15)->withQueryString(),
        ]);
    }

    public function show(Patient $patient): View
    {
        $patient->load('user', 'commandes.details', 'ordonnances');

        return view('pharmacien.patients.show', compact('patient'));
    }
}
