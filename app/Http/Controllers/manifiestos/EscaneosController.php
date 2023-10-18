<?php

namespace App\Http\Controllers\manifiestos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\PickEscaneos;
use App\Models\KanbanActual;
use App\Models\Scanners;
use App\Models\TrackingBom;

class EscaneosController extends Controller
{
    public function getLecturas($brazo, $tramo, $ubicacion, $cantidad) {
        set_time_limit(180);

        // Obtiene el scanner asignado al tramo seleccionado, puede estar el mismo nombre de tramo en varios brazos
        $scanner = Scanners::select(
            'scanner'
        )
        ->where('brazo', $brazo)
        ->where('tramo', $tramo)
        ->first();

        // Se obtienen los N últimos registros en base al scanner seleccionado
        $escaneos = KanbanActual::select(
            'seq',
            'mode as modelo',
            'Folio',
            'Fecha',
            'Escaner',
            'NumSerie',
        )
        ->where('Escaner', $scanner->scanner)
        ->orderBy('Fecha', 'desc')
        ->take($cantidad ?? 10)
        ->get();

        $consultado = '';
        $materiales = [];
        $counter = 0;

        foreach ($escaneos as $modelo) {
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
                ->where('v.DELIVERY_LOCATION', $tramo)
                ->where('v.WHERE_USED_ITEM', $brazo)
                ->where('v.WHERE_USED_LINE', $ubicacion)
                ->where('ModeloIngenieria', $modelo->modelo)
                ->get();
                $counter += 1;

            }

            $modelo->materiales = $materiales;
            $consultado = $modelo->modelo;
        }

        return response([
            'data' => $escaneos
        ]);
    }

    public function getLecturasByNumSerie($brazo, $tramo, $ubicacion, $num_serie, $cantidad) {
        set_time_limit(180);

        // Obtiene el scanner asignado al tramo seleccionado, puede estar el mismo nombre de tramo en varios brazos
        $scanner = Scanners::select(
            'scanner'
        )
        ->where('brazo', $brazo)
        ->where('tramo', $tramo)
        ->first();

        // Obtiene el registro del número de serie para comenzar a buscar a partir de este
        $primerSerial = KanbanActual::select(
            'seq',
            'mode as modelo',
            'Folio',
            'Fecha',
            'Escaner',
            'NumSerie',
        )
        ->where('Escaner', $scanner->scanner)
        ->where('NumSerie', $num_serie)
        ->orderBy('Fecha', 'desc')
        ->first();

        // Se obtienen los N últimos registros en base al scanner seleccionado
        $escaneos = KanbanActual::select(
            'seq',
            'mode as modelo',
            'Folio',
            'Fecha',
            'Escaner',
            'NumSerie',
        )
        ->where('Escaner', $scanner->scanner)
        // ->where('Fecha', '>=', $primerSerial->Fecha)
        ->orderBy('Fecha', 'desc')
        ->take(($cantidad ?? 10) + $num_serie)
        ->get();

        $filtrados = [];
        $reversed = [];
        $index = 0;

        foreach ($escaneos as $elemento) {
            if( $index < $num_serie )
                array_push($filtrados, $elemento);

            $index++;
        }

        $consultado = '';
        $materiales = [];
        $counter = 0;

        // foreach ($escaneos as $modelo) {
        foreach ($filtrados as $modelo) {
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
                ->where('v.DELIVERY_LOCATION', $tramo)
                ->where('v.WHERE_USED_ITEM', $brazo)
                ->where('v.WHERE_USED_LINE', $ubicacion)
                ->where('ModeloIngenieria', $modelo->modelo)
                ->get();
                $counter += 1;
            }

            $modelo->materiales = $materiales;
            $consultado = $modelo->modelo;
        }

        return response([
            'data' => $filtrados
        ]);
    }

}
