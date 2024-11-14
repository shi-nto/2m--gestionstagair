<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class attestation extends Model
{
    use HasFactory;
    protected $table = 'attestation';
    protected $fillable = [ 
        'id_a' , 'year'
    ];
}
