<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Pharmacie;
use App\Models\Pharmacien;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::query();

        if ($role = $request->input('role')) {
            $query->where('role', $role);
        }
        if ($q = $request->string('q')->trim()->value()) {
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('prenom', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            });
        }

        return view('admin.users.index', [
            'users' => $query->latest()->paginate(15)->withQueryString(),
            'role' => $role,
        ]);
    }

    public function create(): View
    {
        return view('admin.users.form', [
            'user' => new User,
            'pharmacies' => Pharmacie::all(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'prenom' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'telephone' => ['nullable', 'string', 'max:30'],
            'role' => ['required', 'in:patient,pharmacien,admin'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'pharmacie_id' => ['nullable', 'exists:pharmacies,id'],
            'numero_ordre' => ['nullable', 'string', 'max:255'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'prenom' => $data['prenom'] ?? null,
            'email' => $data['email'],
            'telephone' => $data['telephone'] ?? null,
            'role' => $data['role'],
            'password' => Hash::make($data['password']),
        ]);

        $this->syncRoleProfile($user, $data);

        return redirect()->route('admin.users.index')->with('success', 'Utilisateur créé.');
    }

    public function edit(User $user): View
    {
        return view('admin.users.form', [
            'user' => $user,
            'pharmacies' => Pharmacie::all(),
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'prenom' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,'.$user->id],
            'telephone' => ['nullable', 'string', 'max:30'],
            'role' => ['required', 'in:patient,pharmacien,admin'],
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'pharmacie_id' => ['nullable', 'exists:pharmacies,id'],
            'numero_ordre' => ['nullable', 'string', 'max:255'],
        ]);

        $user->update([
            'name' => $data['name'],
            'prenom' => $data['prenom'] ?? null,
            'email' => $data['email'],
            'telephone' => $data['telephone'] ?? null,
            'role' => $data['role'],
        ]);

        if (! empty($data['password'])) {
            $user->update(['password' => Hash::make($data['password'])]);
        }

        $this->syncRoleProfile($user, $data);

        return redirect()->route('admin.users.index')->with('success', 'Utilisateur mis à jour.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ((int) $user->id === (int) auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $user->delete();

        return back()->with('success', 'Utilisateur supprimé.');
    }

    private function syncRoleProfile(User $user, array $data): void
    {
        if ($data['role'] === 'patient') {
            Patient::firstOrCreate(['user_id' => $user->id]);
        }

        if ($data['role'] === 'pharmacien') {
            Pharmacien::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'pharmacie_id' => $data['pharmacie_id'] ?? null,
                    'numero_ordre' => $data['numero_ordre'] ?? null,
                ]
            );
        }
    }
}
