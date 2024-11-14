<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\stagiaires;
use App\Models\encadrants;
use App\Models\personnel;

class prolongation extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_stag',
        'motif',
        'date_debut',
        'date_fin',
        'old_date_fin',
        'id_pers',
        'old_pers',
        'id_enc',
        'old_enc',
    ];
    protected $table = 'prolongation';
    public function stagiaire()
    {
        return $this->belongsTo(stagiaires::class, 'id_stag');
    }
    public function encadrant()
    {
        return $this->belongsTo(encadrants::class, 'id_enc');
    }
    public function old_encadrant()
    {
        return $this->belongsTo(encadrants::class, 'old_enc');
    }
    public function personnel()
    {
        return $this->belongsTo(personnel::class, 'id_pers');
    }
    public function old_personnel()
    {
        return $this->belongsTo(personnel::class, 'old_pers');
    }
}
