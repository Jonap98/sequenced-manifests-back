<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingBom extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv2';
    protected $table = 'TrackingBOM';
    protected $fillable = [
        'ModeloIngenieria',
        'Parte',
        'ParteNombre',
    ];
}
