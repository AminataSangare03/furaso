<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        $patient = $this->patient();

        return view('patient.dashboard', [
            'user' => $user,
            'commandes' => $patient?->commandes()->take(5)->get() ?? collect(),
            'ordonnances' => $patient?->ordonnances()->take(5)->get() ?? collect(),
            'notifications' => $user->notificationsFuraso()->take(5)->get(),
            'nbCommandes' => $patient?->commandes()->count() ?? 0,
            'nbOrdonnances' => $patient?->ordonnances()->count() ?? 0,
            'nbFavoris' => $user->favoris()->count(),
        ]);
    }

    private function patient(): ?Patient
    {
        return auth()->user()->patient;
    }
}
