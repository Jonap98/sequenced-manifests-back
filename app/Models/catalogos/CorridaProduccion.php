<?php

namespace App\Models\catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorridaProduccion extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv2';
    protected $table = 'req_programcorrida';
    protected $fillable = [
        'reg',
        'sec',
        'modelo',
        'qty',
        'linea',
        'fecha',
    ];
}
