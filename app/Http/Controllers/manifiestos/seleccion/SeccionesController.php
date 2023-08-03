<?php

namespace App\Http\Controllers\manifiestos\seleccion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\catalogos\Secciones;
use App\Models\PFEP;
use App\Models\Scanners;

class SeccionesController extends Controller
{
    public function getBrazos() {
        $brazos = Scanners::select(
            'brazo'
        )
        ->distinct()
        ->get();

        return response([
            'data' => $brazos
        ]);
    }

    public function getSecciones($brazo) {

        // $secciones = Secciones::select(
        //     'nombre'
        // )
        // ->where('linea', $brazo)
        // ->get();
        $secciones = PFEP::select(
            'DELIVERY_LOCATION as tramo'
        )
        ->where('WHERE_USED_ITEM', $brazo)
        ->distinct()
        ->get();

        return response([
            'data' => $secciones
        ]);
    }
}
