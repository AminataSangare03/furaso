<?php

namespace App\Http\Controllers;

use App\Models\NotificationFuraso;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(): View
    {
        return view('notifications.index', [
            'notifications' => auth()->user()->notificationsFuraso()->paginate(20),
        ]);
    }

    public function lire(NotificationFuraso $notification): RedirectResponse
    {
        abort_unless((int) $notification->user_id === (int) auth()->id(), 403);

        $notification->update(['lu' => true]);

        if ($notification->lien) {
            return redirect($notification->lien);
        }

        return back();
    }

    public function toutLire(): RedirectResponse
    {
        auth()->user()->notificationsFuraso()->update(['lu' => true]);

        return back()->with('success', 'Toutes les notifications sont marquées comme lues.');
    }
}
