<?php

namespace App\Services;

use App\Models\Medicament;
use Illuminate\Support\Collection;

class PanierService
{
    private const SESSION_KEY = 'panier';

    /**
     * @return array<int, int> medicament_id => quantite
     */
    public function items(): array
    {
        return session()->get(self::SESSION_KEY, []);
    }

    public function ajouter(int $medicamentId, int $quantite = 1): void
    {
        $items = $this->items();
        $items[$medicamentId] = ($items[$medicamentId] ?? 0) + max(1, $quantite);
        session()->put(self::SESSION_KEY, $items);
    }

    public function modifier(int $medicamentId, int $quantite): void
    {
        $items = $this->items();
        if ($quantite <= 0) {
            unset($items[$medicamentId]);
        } else {
            $items[$medicamentId] = $quantite;
        }
        session()->put(self::SESSION_KEY, $items);
    }

    public function supprimer(int $medicamentId): void
    {
        $items = $this->items();
        unset($items[$medicamentId]);
        session()->put(self::SESSION_KEY, $items);
    }

    public function vider(): void
    {
        session()->forget(self::SESSION_KEY);
    }

    /**
     * Lignes du panier enrichies avec les médicaments.
     *
     * @return Collection<int, array{medicament: Medicament, quantite: int, sous_total: float}>
     */
    public function lignes(): Collection
    {
        $items = $this->items();
        if (empty($items)) {
            return collect();
        }

        return Medicament::whereIn('id', array_keys($items))->get()
            ->map(fn (Medicament $m) => [
                'medicament' => $m,
                'quantite' => $items[$m->id],
                'sous_total' => (float) $m->prix * $items[$m->id],
            ])->values();
    }

    public function total(): float
    {
        return (float) $this->lignes()->sum('sous_total');
    }

    public function nombreArticles(): int
    {
        return array_sum($this->items());
    }

    public function contientOrdonnance(): bool
    {
        return $this->lignes()->contains(fn ($l) => $l['medicament']->ordonnance_obligatoire);
    }
}
