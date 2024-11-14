<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\encadrants;
use App\Models\personnel;
use App\Models\prolongation;


class stagiaires extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'prenom',
        'institut',
        'formation',
        'gsm',
        'nature_stage',
        'theme',
        'date_debut',
        'date_fin',
        'id_enc',
        'id_pers',
        'gender',
    ];
    protected $table = 'stagiaires';

    public function encadrant()
    {
        return $this->belongsTo(encadrants::class, 'id_enc');
    }
    public function personnel()
    {
        return $this->belongsTo(personnel::class, 'id_pers');
    }
    public function departement()
    {
        return $this->belongsTo(departements::class, 'id_dep');
    }
    public function prolongation()
    {
        return $this->hasMany(prolongation::class, 'id_stag');
    }
}
