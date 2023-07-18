<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examen extends Model
{
    use HasFactory;

    protected $table = 'examenes';
    protected $primaryKey = 'id_examen';
    protected $fillable = [
        'calificacion'
    ];
}
