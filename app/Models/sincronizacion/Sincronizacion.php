<?php

namespace App\Models\sincronizacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sincronizacion extends Model
{
    use HasFactory;
    protected $table = 'MANIFIESTOS_sincronizacion';
    protected $fillable = [
        'brazo',
        'tramo',
        'ubicacion',
        'scanner',
        'diferencia',
    ];

}
