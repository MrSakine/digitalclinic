<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'contenu',
        'destinataire',
        'consultation_id',
        'boiteDialogue'
    ];

    public function envoyeur() {
        return $this->morphTo();
    }
}
