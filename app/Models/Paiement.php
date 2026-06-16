<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Paiement extends Model
{
    protected $table = 'paiements';

    protected $fillable = [
        'commande_id', 'montant', 'methode', 'statut', 'reference',
    ];

    protected $casts = [
        'montant' => 'decimal:2',
    ];

    public function commande(): BelongsTo
    {
        return $this->belongsTo(Commande::class);
    }
}
