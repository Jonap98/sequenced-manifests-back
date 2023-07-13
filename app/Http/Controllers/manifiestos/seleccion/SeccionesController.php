<?php

namespace App\Http\Controllers\manifiestos\seleccion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\catalogos\Secciones;

class SeccionesController extends Controller
{
    public function getSecciones($brazo) {

        $secciones = Secciones::select(
            'nombre'
        )
        ->where('linea', $brazo)
        ->get();

        return response([
            'data' => $secciones
        ]);
    }
}
