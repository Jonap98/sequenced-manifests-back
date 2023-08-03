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
    public function getLecturas($brazo, $tramo) {
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
        ->take(23)
        ->get();

        $consultado = '';
        $materiales = [];
        $counter = 0;

        foreach ($escaneos as $modelo) {
            if( $consultado != $modelo->modelo ) {
                // $materiales = PFEP::select(
                //     'PART_NUMBER'
                // )
                // ->where('Modelo')

                // $materiales = TrackingBom::select(
                //     'Parte'
                // )
                // ->where('')
                // ->where('ModeloIngenieria', $modelo->mode)
                // ->get();
                // $modelo->materiales = $materiales;

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
                // ->whereNotIn('CODIGO_MAN', ['', '-'])
                ->where('ModeloIngenieria', $modelo->modelo)
                // ->groupBy('Parte')
                ->get();
                $counter += 1;




            }

            $modelo->materiales = $materiales;
            $consultado = $modelo->modelo;
        }

        return response([
            // 'counter' => $counter,
            'data' => $escaneos
        ]);
    }
}
