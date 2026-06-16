<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Livraison extends Model
{
    protected $table = 'livraisons';

    protected $fillable = [
        'commande_id', 'livreur', 'livreur_telephone', 'zone', 'frais',
        'statut', 'date_livraison_prevue', 'date_livraison',
    ];

    protected $casts = [
        'frais' => 'decimal:2',
        'date_livraison_prevue' => 'datetime',
        'date_livraison' => 'datetime',
    ];

    public function commande(): BelongsTo
    {
        return $this->belongsTo(Commande::class);
    }
}
