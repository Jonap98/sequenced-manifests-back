<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KanbanActual extends Model
{
    use HasFactory;
    protected $connection = 'sqlsrv3';
    protected $table = 'V_KanBanActuales';
    protected $fillable = [
        'Seq',
        'mode',
        'Folio',
        'Fecha',
        'Escaner',
        'NumSerie',
    ];
}
