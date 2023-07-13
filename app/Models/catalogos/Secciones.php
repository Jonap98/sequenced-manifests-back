<?php

namespace App\Models\catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Secciones extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv3';
    protected $table = 'CM_secciones';
    protected $fillable = [
        'seccion',
        'linea',
        'nombre',
    ];
}
