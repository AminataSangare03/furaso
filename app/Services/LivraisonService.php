<?php

namespace App\Services;

class LivraisonService
{
    /**
     * Montant d'achat (FCFA) à partir duquel la livraison est offerte.
     */
    public const SEUIL_LIVRAISON_GRATUITE = 25000;

    /**
     * Zones de livraison (quartiers de Bamako, périphérie et régions du Mali)
     * avec frais (FCFA) et délai estimé.
     *
     * @return array<string, array{frais: int, delai: string, groupe: string}>
     */
    public static function zones(): array
    {
        $zones = [];

        $communes = [
            'Bamako - Commune I' => [
                'frais' => 1000, 'delai' => '30 à 60 min',
                'quartiers' => ['Banconi', 'Djélibougou', 'Boulkassoumbougou', 'Korofina', 'Sotuba', 'Fadjiguila', 'Sikoroni', 'Doumanzana'],
            ],
            'Bamako - Commune II' => [
                'frais' => 1000, 'delai' => '30 à 60 min',
                'quartiers' => ['Hippodrome', 'Niaréla', 'Quinzambougou', 'Médina Coura', 'Bagadadji', 'Bozola', 'TSF', 'Bakaribougou', 'Zone Industrielle'],
            ],
            'Bamako - Commune III' => [
                'frais' => 1000, 'delai' => '30 à 60 min',
                'quartiers' => ['Centre-ville', 'Bamako Coura', 'Dravéla', 'Badialan', 'Ouolofobougou', 'Point G', 'Koulouba', 'Niomirambougou', 'Samé'],
            ],
            'Bamako - Commune IV' => [
                'frais' => 1500, 'delai' => '1 à 2h',
                'quartiers' => ['Lafiabougou', 'Hamdallaye', 'Sébénikoro', 'Djicoroni Para', 'Lassa', 'Sibiribougou', 'Kalabambougou', 'Taliko'],
            ],
            'Bamako - Commune V' => [
                'frais' => 1500, 'delai' => '1 à 2h',
                'quartiers' => ['Badalabougou', 'Sabalibougou', 'Daoudabougou', 'Quartier Mali', 'Torokorobougou', 'Baco Djicoroni', 'Kalaban Coura', 'Garantiguibougou'],
            ],
            'Bamako - Commune VI' => [
                'frais' => 2000, 'delai' => '2 à 3h',
                'quartiers' => ['Faladié', 'Banankabougou', 'Sogoniko', 'Magnambougou', 'Sokorodji', 'Niamakoro', 'Yirimadio', 'Sénou', 'Missabougou', 'Dianéguela'],
            ],
        ];

        foreach ($communes as $commune => $info) {
            foreach ($info['quartiers'] as $quartier) {
                $zones["{$quartier} ({$commune})"] = [
                    'frais' => $info['frais'],
                    'delai' => $info['delai'],
                    'groupe' => $commune,
                ];
            }
        }

        $zones['Kati'] = ['frais' => 2500, 'delai' => '3 à 4h', 'groupe' => 'Périphérie de Bamako'];
        $zones['Kalaban Coro'] = ['frais' => 2500, 'delai' => '3 à 4h', 'groupe' => 'Périphérie de Bamako'];
        $zones['Sénou Aéroport'] = ['frais' => 2500, 'delai' => '3 à 4h', 'groupe' => 'Périphérie de Bamako'];

        $regions = [
            'Koulikoro' => ['frais' => 3000, 'delai' => '1 à 2 jours'],
            'Ségou' => ['frais' => 4000, 'delai' => '2 à 3 jours'],
            'Sikasso' => ['frais' => 5000, 'delai' => '2 à 4 jours'],
            'Kayes' => ['frais' => 5000, 'delai' => '2 à 4 jours'],
            'Mopti' => ['frais' => 6000, 'delai' => '3 à 5 jours'],
            'Tombouctou' => ['frais' => 8000, 'delai' => '4 à 7 jours'],
            'Gao' => ['frais' => 8000, 'delai' => '4 à 7 jours'],
            'Kidal' => ['frais' => 10000, 'delai' => '5 à 8 jours'],
        ];

        foreach ($regions as $region => $info) {
            $zones[$region] = ['frais' => $info['frais'], 'delai' => $info['delai'], 'groupe' => 'Régions'];
        }

        return $zones;
    }

    public static function fraisPour(?string $zone): int
    {
        return self::zones()[$zone]['frais'] ?? 2000;
    }

    /**
     * Frais réels en tenant compte de la livraison gratuite au-dessus du seuil.
     */
    public static function fraisAvecSeuil(?string $zone, float $montantAchat): int
    {
        if ($montantAchat >= self::SEUIL_LIVRAISON_GRATUITE) {
            return 0;
        }

        return self::fraisPour($zone);
    }

    public static function delaiPour(?string $zone): string
    {
        return self::zones()[$zone]['delai'] ?? 'À déterminer';
    }

    /**
     * Créneaux de livraison proposés au client.
     *
     * @return array<string, string>
     */
    public static function creneaux(): array
    {
        return [
            'express' => 'Express — au plus vite (moins de 2h sur Bamako)',
            'journee' => 'Dans la journée',
            'soir' => 'En soirée (17h - 20h)',
            'programme' => 'Programmé (le pharmacien vous appelle pour convenir de l\'heure)',
        ];
    }

    public static function creneauLibelle(?string $cle): string
    {
        return self::creneaux()[$cle] ?? 'Au plus vite';
    }

    /**
     * Modes de paiement adaptés au Mali.
     *
     * @return array<string, string>
     */
    public static function modesPaiement(): array
    {
        return [
            'livraison' => 'Paiement à la livraison (espèces)',
            'orange_money' => 'Orange Money',
            'moov_money' => 'Moov Money',
            'carte' => 'Carte bancaire',
        ];
    }
}
