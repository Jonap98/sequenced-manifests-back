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

    public function getUbicaciones($brazo, $seccion) {
        $ubicaciones = PFEP::select(
            'WHERE_USED_LINE as ubicacion'
        )
        ->where('WHERE_USED_ITEM', $brazo)
        ->where('DELIVERY_LOCATION', $seccion)
        ->distinct()
        ->get();

        return response([
            'data' => $ubicaciones
        ]);
    }
}
