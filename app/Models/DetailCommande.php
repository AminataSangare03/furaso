<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailCommande extends Model
{
    protected $table = 'details_commandes';

    protected $fillable = [
        'commande_id', 'medicament_id', 'nom_medicament', 'quantite', 'prix',
    ];

    protected $casts = [
        'quantite' => 'integer',
        'prix' => 'decimal:2',
    ];

    public function commande(): BelongsTo
    {
        return $this->belongsTo(Commande::class);
    }

    public function medicament(): BelongsTo
    {
        return $this->belongsTo(Medicament::class);
    }

    public function getSousTotalAttribute(): float
    {
        return (float) $this->prix * $this->quantite;
    }
}
