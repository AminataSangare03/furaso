<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Medicament extends Model
{
    use HasFactory;

    protected $table = 'medicaments';

    protected $fillable = [
        'categorie_id', 'pharmacie_id', 'nom', 'description', 'dosage',
        'laboratoire', 'prix', 'stock', 'image', 'ordonnance_obligatoire',
        'effets_secondaires', 'conseils_utilisation', 'maladie', 'date_expiration',
    ];

    protected $casts = [
        'ordonnance_obligatoire' => 'boolean',
        'prix' => 'decimal:2',
        'stock' => 'integer',
        'date_expiration' => 'date',
    ];

    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }

    public function pharmacie(): BelongsTo
    {
        return $this->belongsTo(Pharmacie::class);
    }

    public function getEnStockAttribute(): bool
    {
        return $this->stock > 0;
    }
}
