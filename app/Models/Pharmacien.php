<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pharmacien extends Model
{
    protected $table = 'pharmaciens';

    protected $fillable = [
        'user_id', 'pharmacie_id', 'numero_ordre', 'specialite',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pharmacie(): BelongsTo
    {
        return $this->belongsTo(Pharmacie::class);
    }
}
