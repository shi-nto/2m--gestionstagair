<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\encadrants;
class personnel extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_enc',
       
    ];

    protected $table = 'personnel';

    public function encadrant()
    {
        return $this->belongsTo(encadrants::class, 'id_enc');
    }
}
