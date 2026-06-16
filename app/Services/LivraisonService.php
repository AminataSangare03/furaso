<?php

namespace App\Services;

class LivraisonService
{
    /**
     * Zones de livraison du Mali avec frais (FCFA) et délai estimé (jours).
     *
     * @return array<string, array{frais: int, delai: string, groupe: string}>
     */
    public static function zones(): array
    {
        return [
            'Bamako - Commune I' => ['frais' => 1000, 'delai' => '1 à 2h', 'groupe' => 'Bamako'],
            'Bamako - Commune II' => ['frais' => 1000, 'delai' => '1 à 2h', 'groupe' => 'Bamako'],
            'Bamako - Commune III' => ['frais' => 1000, 'delai' => '1 à 2h', 'groupe' => 'Bamako'],
            'Bamako - Commune IV' => ['frais' => 1500, 'delai' => '1 à 3h', 'groupe' => 'Bamako'],
            'Bamako - Commune V' => ['frais' => 1500, 'delai' => '1 à 3h', 'groupe' => 'Bamako'],
            'Bamako - Commune VI' => ['frais' => 1500, 'delai' => '1 à 3h', 'groupe' => 'Bamako'],
            'Kayes' => ['frais' => 5000, 'delai' => '2 à 4 jours', 'groupe' => 'Régions'],
            'Koulikoro' => ['frais' => 3000, 'delai' => '1 à 2 jours', 'groupe' => 'Régions'],
            'Sikasso' => ['frais' => 5000, 'delai' => '2 à 4 jours', 'groupe' => 'Régions'],
            'Ségou' => ['frais' => 4000, 'delai' => '2 à 3 jours', 'groupe' => 'Régions'],
            'Mopti' => ['frais' => 6000, 'delai' => '3 à 5 jours', 'groupe' => 'Régions'],
            'Tombouctou' => ['frais' => 8000, 'delai' => '4 à 7 jours', 'groupe' => 'Régions'],
            'Gao' => ['frais' => 8000, 'delai' => '4 à 7 jours', 'groupe' => 'Régions'],
            'Kidal' => ['frais' => 10000, 'delai' => '5 à 8 jours', 'groupe' => 'Régions'],
        ];
    }

    public static function fraisPour(?string $zone): int
    {
        return self::zones()[$zone]['frais'] ?? 2000;
    }

    public static function delaiPour(?string $zone): string
    {
        return self::zones()[$zone]['delai'] ?? 'À déterminer';
    }

    /**
     * Modes de paiement adaptés au Mali.
     *
     * @return array<string, string>
     */
    public static function modesPaiement(): array
    {
        return [
            'livraison' => 'Paiement à la livraison',
            'orange_money' => 'Orange Money',
            'moov_money' => 'Moov Money',
            'carte' => 'Carte bancaire',
        ];
    }
}
