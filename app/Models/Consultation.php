<?php

namespace App\Models;

use App\Models\Patient;
use App\Models\Paiement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Consultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'typeConsultation',
        'prixConsultation',
        'traiter',
        'payer',
        'dateCreation',
        'dateValidation'
    ];

    public function patient() {
        return $this->belongsTo(Patient::class);
    }

    public function consultation_paiement() {
        return $this->morphOne(Paiement::class, 'consultation_paiement');
    }

    public function fiche_consultation() {
        return $this->hasOne(FicheConsultation::class);
    }
}
