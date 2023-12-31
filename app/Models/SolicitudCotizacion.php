<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudCotizacion extends Model
{
    use HasFactory;
    protected $table = 'solicitudes_cotizacion';
    protected $fillable = [
        'idOrdenRequisicion',
        'idProveedor',
    ];
}
