<?php

namespace App\Http\Controllers\manifiestos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EscaneosController extends Controller
{
    public function getLecturas() {
        set_time_limit(180);

        $ultimo_escaneo = PickEscaneos::select(
            'seq',
            'model',
            'fecha_escaneo',
            'scanner',
        )
        ->orderBy('id', 'desc')
        ->first();

        // $escaneos_posteriores =
    }
}
