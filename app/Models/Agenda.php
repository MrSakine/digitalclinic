<?php

namespace App\Models;

use App\Models\Medecin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Agenda extends Model
{
    use HasFactory;

    protected $fillable = [
        'jour',
        'disponibilite'
    ];

    public function medecin() {
        return $this->belongsTo(Medecin::class);
    }
}
