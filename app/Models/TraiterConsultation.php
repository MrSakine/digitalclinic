<?php

namespace App\Models;

use App\Models\Medecin;
use App\Models\Resultat;
use App\Models\Ordonnance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TraiterConsultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'for_patient',
        'for_patient_consultation',
        'for_consultation'
    ];

    public function medecin() {
        return $this->belongsTo(Medecin::class);
    }
}