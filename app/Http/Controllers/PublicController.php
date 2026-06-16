<?php

namespace App\Http\Controllers;

use App\Models\Medicament;
use App\Models\Pharmacie;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicController extends Controller
{
    public function home(): View
    {
        return view('public.home', [
            'pharmacies' => Pharmacie::where('partenaire', true)->take(4)->get(),
            'populaires' => Medicament::where('stock', '>', 0)->latest()->take(8)->get(),
        ]);
    }

    public function about(): View
    {
        return view('public.about');
    }

    public function services(): View
    {
        return view('public.services');
    }

    public function pharmacies(): View
    {
        return view('public.pharmacies', [
            'pharmacies' => Pharmacie::withCount('medicaments')->orderBy('region')->get(),
        ]);
    }

    public function contact(): View
    {
        return view('public.contact');
    }

    public function contactEnvoyer(Request $request): RedirectResponse
    {
        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'message' => ['required', 'string'],
        ]);

        // Notifie les administrateurs du nouveau message de contact.
        foreach (User::where('role', 'admin')->pluck('id') as $adminId) {
            NotificationService::envoyer($adminId, 'Nouveau message de contact', $request->input('message'));
        }

        return back()->with('success', 'Votre message a été envoyé. Nous vous répondrons rapidement.');
    }

    public function faq(): View
    {
        return view('public.faq');
    }

    public function blog(): View
    {
        return view('public.blog');
    }
}
