<?php

namespace App\Services;

use App\Models\NotificationFuraso;

class NotificationService
{
    public static function envoyer(int $userId, string $titre, ?string $contenu = null, ?string $lien = null): void
    {
        NotificationFuraso::create([
            'user_id' => $userId,
            'titre' => $titre,
            'contenu' => $contenu,
            'lien' => $lien,
            'lu' => false,
        ]);
    }
}
