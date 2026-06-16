<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'name', 'prenom', 'email', 'password', 'role', 'telephone', 'sexe',
    'date_naissance', 'photo', 'adresse', 'quartier', 'ville', 'region',
    'personne_urgence', 'telephone_urgence',
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'date_naissance' => 'date',
            'password' => 'hashed',
        ];
    }

    public function isPatient(): bool
    {
        return $this->role === 'patient';
    }

    public function isPharmacien(): bool
    {
        return $this->role === 'pharmacien';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function getNomCompletAttribute(): string
    {
        return trim(($this->prenom ?? '').' '.$this->name);
    }

    public function patient(): HasOne
    {
        return $this->hasOne(Patient::class);
    }

    public function pharmacien(): HasOne
    {
        return $this->hasOne(Pharmacien::class);
    }

    public function favoris(): HasMany
    {
        return $this->hasMany(Favori::class);
    }

    public function notificationsFuraso(): HasMany
    {
        return $this->hasMany(NotificationFuraso::class)->latest();
    }

    public function messagesEnvoyes(): HasMany
    {
        return $this->hasMany(Message::class, 'expediteur_id');
    }

    public function messagesRecus(): HasMany
    {
        return $this->hasMany(Message::class, 'destinataire_id');
    }
}
