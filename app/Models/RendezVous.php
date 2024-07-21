<?php

namespace App\Models;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RendezVous extends Model
{
    use HasFactory;

    protected $fillable = [
        'typeConsultation',
        'dateConsultation',
        'heureConsultation',
        'prix'
    ];

    public function patient() {
        return $this->belongsTo(Patient::class);
    }

    public function consultation_paiement() {
        return $this->morphOne(Paiement::class, 'consultation_paiement');
    }
}
