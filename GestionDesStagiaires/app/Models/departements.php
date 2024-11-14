<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class departements extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'deleted',
    ];
    protected $table = 'departements';
    public function encadrants()
{
    return $this->hasMany(Encadrant::class, 'id_dep');
}
public function stagiaires()
{
    return $this->hasMany(stagiaires::class, 'id_dep');
}
}
