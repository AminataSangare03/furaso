<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'sexe' => ['nullable', 'in:M,F'],
            'date_naissance' => ['nullable', 'date'],
            'telephone' => ['required', 'string', 'max:30'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'adresse' => ['nullable', 'string', 'max:255'],
            'quartier' => ['nullable', 'string', 'max:255'],
            'ville' => ['nullable', 'string', 'max:255'],
            'region' => ['nullable', 'string', 'max:255'],
            'personne_urgence' => ['nullable', 'string', 'max:255'],
            'telephone_urgence' => ['nullable', 'string', 'max:30'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'prenom' => $data['prenom'],
            'sexe' => $data['sexe'] ?? null,
            'date_naissance' => $data['date_naissance'] ?? null,
            'telephone' => $data['telephone'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'patient',
            'adresse' => $data['adresse'] ?? null,
            'quartier' => $data['quartier'] ?? null,
            'ville' => $data['ville'] ?? null,
            'region' => $data['region'] ?? null,
            'personne_urgence' => $data['personne_urgence'] ?? null,
            'telephone_urgence' => $data['telephone_urgence'] ?? null,
        ]);

        Patient::create([
            'user_id' => $user->id,
            'date_naissance' => $data['date_naissance'] ?? null,
            'sexe' => $data['sexe'] ?? null,
            'personne_urgence' => $data['personne_urgence'] ?? null,
            'telephone_urgence' => $data['telephone_urgence'] ?? null,
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('patient.dashboard')
            ->with('success', 'Bienvenue sur Furaso, '.$user->prenom.' !');
    }
}
