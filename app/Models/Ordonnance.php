<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ordonnance extends Model
{
    protected $table = 'ordonnances';

    protected $fillable = [
        'patient_id', 'pharmacie_id', 'fichier', 'type', 'statut',
        'commentaire_pharmacien', 'date_envoi',
    ];

    protected $casts = [
        'date_envoi' => 'datetime',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function pharmacie(): BelongsTo
    {
        return $this->belongsTo(Pharmacie::class);
    }

    public function statutLibelle(): string
    {
        return match ($this->statut) {
            'validee' => 'Validée',
            'refusee' => 'Refusée',
            default => 'En attente',
        };
    }
}
