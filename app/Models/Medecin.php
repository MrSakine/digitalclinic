<?php

namespace App\Models;

use App\Models\Agenda;
use App\Models\Message;
use App\Models\Resultat;
use App\Models\Ordonnance;
use Laravel\Sanctum\HasApiTokens;
use App\Models\TraiterConsultation;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Medecin extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $fillable = [
        'email',
        'password',
        'nom',
        'prenom',
        'genre',
        'dateNaissance',
        'adresse',
        'telephone',
        'hopital',
        'specialite'
    ];

    public function traiter() {
        return $this->hasMany(TraiterConsultation::class);
    }

    public function resultat_consultation() {
        return $this->hasOne(Resultat::class);
    }

    public function ordonnance_consultation() {
        return $this->hasMany(Ordonnance::class);
    }

    public function message() {
        return $this->morphMany(Message::class, 'envoyeur');
    }

    public function agenda() {
        return $this->hasMany(Agenda::class);
    }
}
