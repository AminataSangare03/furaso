<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfilController extends Controller
{
    public function edit(): View
    {
        return view('patient.profil', ['user' => auth()->user()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = auth()->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'telephone' => ['nullable', 'string', 'max:30'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'sexe' => ['nullable', 'in:M,F'],
            'date_naissance' => ['nullable', 'date'],
            'adresse' => ['nullable', 'string', 'max:255'],
            'quartier' => ['nullable', 'string', 'max:255'],
            'ville' => ['nullable', 'string', 'max:255'],
            'region' => ['nullable', 'string', 'max:255'],
            'personne_urgence' => ['nullable', 'string', 'max:255'],
            'telephone_urgence' => ['nullable', 'string', 'max:30'],
            'photo' => ['nullable', 'image', 'max:4096'],
        ]);

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $user->update($data);

        if ($user->patient) {
            $user->patient->update([
                'date_naissance' => $data['date_naissance'] ?? null,
                'sexe' => $data['sexe'] ?? null,
                'personne_urgence' => $data['personne_urgence'] ?? null,
                'telephone_urgence' => $data['telephone_urgence'] ?? null,
            ]);
        }

        return back()->with('success', 'Profil mis à jour.');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        auth()->user()->update(['password' => Hash::make($data['password'])]);

        return back()->with('success', 'Mot de passe modifié.');
    }
}
