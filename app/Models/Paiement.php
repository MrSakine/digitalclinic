<?php

namespace App\Models;

use App\Models\Consultation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'datePaiement',
        'montant',
        'patient_id'
    ];

    public function consultation_paiement() {
        return $this->morphTo();
    }
}
