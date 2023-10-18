<?php

namespace App\Http\Controllers\sincronizacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\sincronizacion\Sincronizacion;
use App\Models\Scanners;
use App\Models\KanbanActual;

class SincronizacionController extends Controller
{
    public function syncBySerial(Request $request) {
        $scanner = Scanners::select(
            'scanner'
        )
        ->where('brazo', $request->brazo)
        ->where('tramo', $request->tramo)
        ->first();

        $objetivo = KanbanActual::select(
            'seq',
            'mode as modelo',
            'Folio',
            'Fecha',
            'Escaner',
            'NumSerie',
        )
        ->where('Escaner', $scanner->scanner)
        ->where('NumSerie', $request->num_serie)
        ->first();

        $cantidad = KanbanActual::where(
            'Escaner', $scanner->scanner
        )
        ->orderBy('Fecha', 'desc')
        ->where('Fecha', '>=', $objetivo->Fecha)
        ->count();

        // En este punto, solo debe interesar la diferencia, validar si lo demás no, para poder eliminarlo
        return response([
            'diferencia' => $cantidad,
        ]);
    }

    public function syncByDifference(Request $request) {
        $scanner = Scanners::select(
            'scanner'
        )
        ->where('brazo', $request->brazo)
        ->where('tramo', $request->tramo)
        ->first();

        $escaneos_posteriores = KanbanActual::select(
            'seq',
            'mode as modelo',
            'Folio',
            'Fecha',
            'Escaner',
            'NumSerie',
        )
        ->where('Escaner', $scanner->scanner)
        ->orderBy('Fecha', 'desc')
        ->take($request->diferencia)
        ->get();

        $consultado = '';
        $materiales = [];
        $counter = 0;
        // Consulta los materiales necesarios para ese modelo según su ubicación
        foreach ($escaneos_posteriores as $modelo) {
            if( $consultado != $modelo->modelo ) {
                $materiales = DB::connection(
                    'sqlsrv2'
                )
                ->table('TrackingBOM as tracking')
                ->select(
                    'tracking.Parte',
                )
                ->distinct()
                ->leftjoin('WRAMateriales.dbo.PFEP_supply as v','PART_NUMBER','=','Parte')
                ->where('v.DELIVERY_LOCATION', $request->tramo)
                ->where('v.WHERE_USED_ITEM', $request->brazo)
                ->where('v.WHERE_USED_LINE', $request->ubicacion)
                ->where('ModeloIngenieria', $modelo->modelo)
                ->get();
                $counter += 1;
            }

            $modelo->materiales = $materiales;
            $consultado = $modelo->modelo;
        }

        return response([
            'msg' => '¡Estación sincronizada exitosamente!',
            'diff' => count($escaneos_posteriores),
            'data' => $escaneos_posteriores
        ]);
    }

}
