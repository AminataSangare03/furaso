<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Commande extends Model
{
    protected $table = 'commandes';

    protected $fillable = [
        'patient_id', 'pharmacie_id', 'ordonnance_id', 'montant_total',
        'frais_livraison', 'statut', 'mode_paiement', 'adresse_livraison',
        'zone_livraison',
    ];

    protected $casts = [
        'montant_total' => 'decimal:2',
        'frais_livraison' => 'decimal:2',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function pharmacie(): BelongsTo
    {
        return $this->belongsTo(Pharmacie::class);
    }

    public function ordonnance(): BelongsTo
    {
        return $this->belongsTo(Ordonnance::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(DetailCommande::class);
    }

    public function paiement(): HasOne
    {
        return $this->hasOne(Paiement::class);
    }

    public function livraison(): HasOne
    {
        return $this->hasOne(Livraison::class);
    }

    public function statutLibelle(): string
    {
        return match ($this->statut) {
            'confirmee' => 'Confirmée',
            'preparee' => 'Préparée',
            'expediee' => 'Expédiée',
            'livree' => 'Livrée',
            'annulee' => 'Annulée',
            default => 'En attente',
        };
    }
}
