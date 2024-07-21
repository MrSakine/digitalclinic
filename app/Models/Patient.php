<?php

namespace App\Models;

use App\Models\Message;
use App\Models\RendezVous;
use App\Models\Consultation;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Patient extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'email',
        'password',
        'nom',
        'prenom',
        'genre',
        'dateNaissance',
        'adresse',
        'telephone'
    ];

    public function consultation() {
        return $this->hasMany(Consultation::class);
    }

    public function rendez_vous() {
        return $this->hasMany(RendezVous::class);
    }

    public function message() {
        return $this->morphMany(Message::class, 'envoyeur');
    }
}
