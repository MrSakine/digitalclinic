<?php

namespace App\Models;

use App\Models\Medecin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Resultat extends Model
{
    use HasFactory;

    protected $fillable = [
        'conseil',
        'observation',
        'diagnostic'
    ];

    public function medecin() {
        return $this->belongsTo(Medecin::class);
    }
}