<?php

namespace App\Models;

use App\Models\Medecin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ordonnance extends Model
{
    use HasFactory;

    protected $fillable = [
        'medicament',
        'modeEmploi',
        'quantite'
    ];

    public function medecin() {
        return $this->belongsTo(Medecin::class);
    }
}