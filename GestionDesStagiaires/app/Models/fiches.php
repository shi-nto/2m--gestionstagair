<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fiches extends Model
{
    use HasFactory;
    protected $fillable = [
        'path',
        'nom',
        'annee',
        'mois',
        'id_stag',
        'type',
        'nombre',
    ];
    protected $table = 'fiches';
  
}
