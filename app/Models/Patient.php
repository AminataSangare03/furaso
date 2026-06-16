<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    protected $fillable = [
        'user_id', 'date_naissance', 'sexe', 'groupe_sanguin',
        'personne_urgence', 'telephone_urgence',
    ];

    protected $casts = [
        'date_naissance' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ordonnances(): HasMany
    {
        return $this->hasMany(Ordonnance::class)->latest();
    }

    public function commandes(): HasMany
    {
        return $this->hasMany(Commande::class)->latest();
    }
}
