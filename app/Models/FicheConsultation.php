<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FicheConsultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'temperature',
        'typeMaladie',
        'descriptionMaladie',
        'antecedentMedicaux',
        'traitementInitial',
        'groupSangin'
    ];

    public function consultation() {
        return $this->belongsTo(Consultation::class);
    }
}