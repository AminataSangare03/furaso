<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pharmacie extends Model
{
    use HasFactory;

    protected $table = 'pharmacies';

    protected $fillable = [
        'nom', 'adresse', 'telephone', 'email', 'ville', 'region',
        'latitude', 'longitude', 'partenaire',
    ];

    protected $casts = [
        'partenaire' => 'boolean',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function pharmaciens(): HasMany
    {
        return $this->hasMany(Pharmacien::class);
    }

    public function medicaments(): HasMany
    {
        return $this->hasMany(Medicament::class);
    }

    public function avis(): HasMany
    {
        return $this->hasMany(Avis::class);
    }

    public function getNoteMoyenneAttribute(): float
    {
        return round((float) $this->avis()->avg('note'), 1);
    }
}
