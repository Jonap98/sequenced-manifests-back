<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scanners extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';
    protected $table = 'MANIFIESTOS_scanners';
    protected $fillable = [
        'brazo',
        'tramo',
        'scanner',
    ];
}
