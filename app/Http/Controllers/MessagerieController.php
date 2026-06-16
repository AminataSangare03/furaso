<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MessagerieController extends Controller
{
    public function index(): View
    {
        $me = auth()->user();

        $contactIds = Message::where('expediteur_id', $me->id)->pluck('destinataire_id')
            ->merge(Message::where('destinataire_id', $me->id)->pluck('expediteur_id'))
            ->unique()->values();

        $contacts = User::whereIn('id', $contactIds)->get();

        // Suggestions de nouveaux contacts selon le rôle.
        $cibleRole = $me->isPatient() ? 'pharmacien' : 'patient';
        $suggestions = User::where('role', $cibleRole)
            ->whereNotIn('id', $contactIds)
            ->take(15)->get();

        return view('messagerie.index', compact('contacts', 'suggestions'));
    }

    public function show(User $user): View
    {
        $me = auth()->user();

        Message::where('expediteur_id', $user->id)
            ->where('destinataire_id', $me->id)
            ->where('lu', false)
            ->update(['lu' => true]);

        $messages = Message::where(function ($q) use ($me, $user) {
            $q->where('expediteur_id', $me->id)->where('destinataire_id', $user->id);
        })->orWhere(function ($q) use ($me, $user) {
            $q->where('expediteur_id', $user->id)->where('destinataire_id', $me->id);
        })->orderBy('created_at')->get();

        return view('messagerie.show', [
            'interlocuteur' => $user,
            'messages' => $messages,
        ]);
    }

    public function store(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $me = auth()->user();

        Message::create([
            'expediteur_id' => $me->id,
            'destinataire_id' => $user->id,
            'message' => $data['message'],
            'lu' => false,
            'date_envoi' => now(),
        ]);

        NotificationService::envoyer($user->id, 'Nouveau message', 'Vous avez reçu un message de '.$me->nom_complet.'.', route('messagerie.show', $me));

        return back()->with('success', 'Message envoyé.');
    }
}
