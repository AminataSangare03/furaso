<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    protected $table = 'messages';

    protected $fillable = [
        'expediteur_id', 'destinataire_id', 'message', 'lu', 'date_envoi',
    ];

    protected $casts = [
        'lu' => 'boolean',
        'date_envoi' => 'datetime',
    ];

    public function expediteur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'expediteur_id');
    }

    public function destinataire(): BelongsTo
    {
        return $this->belongsTo(User::class, 'destinataire_id');
    }
}
