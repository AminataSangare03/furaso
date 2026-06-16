<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificationFuraso extends Model
{
    protected $table = 'notifications_furaso';

    protected $fillable = [
        'user_id', 'titre', 'contenu', 'lien', 'lu',
    ];

    protected $casts = [
        'lu' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
