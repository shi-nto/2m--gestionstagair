<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\departements;

class encadrants extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'prenom',
        'id_dep',
        'deleted',
    ];

    protected $table = 'encadrants';

    public function departement()
    {
        return $this->belongsTo(departements::class, 'id_dep');
    }

}
