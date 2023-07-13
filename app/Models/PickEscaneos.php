<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PickEscaneos extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv2';
    protected $table = 'SEC_pick_escaneos';
    protected $fillable = [
        'id',
        'seq',
        'model',
        'fecha_escaneo',
        'scanner',
        'created_at',
        'updated_at',
        'num_serie',
        'air_tower',
        'folio'
    ];
}
