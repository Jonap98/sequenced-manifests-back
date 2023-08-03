<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PFEP extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv';
    protected $table = 'PFEP_supply';
    protected $fillable = [
        'PART_NUMBER',
        'WHERE_USED_ITEM',
        'DELIVERY_LOCATION',
        'WHERE_USED_LINE',
        'CODIGO_MAN',
    ];
}
