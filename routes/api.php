<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\manifiestos\seleccion\SeccionesController;
use App\Http\Controllers\manifiestos\EscaneosController;
use App\Http\Controllers\sincronizacion\SincronizacionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



// ===============================================================================
// Selección
// ===============================================================================
Route::get('get-secciones/{brazo}', [SeccionesController::class, 'getSecciones'])->name('get-secciones');
Route::get('get-brazos', [SeccionesController::class, 'getBrazos'])->name('get-brazos');
Route::get('get-ubicaciones/{brazo}/{seccion}', [SeccionesController::class, 'getUbicaciones'])->name('get-ubicaciones');

// ===============================================================================
// Manifiestos
// ===============================================================================
Route::get('get-lecturas/{brazo}/{tramo}/{ubicacion}/{cantidad?}', [EscaneosController::class, 'getLecturas'])->name('get-lecturas');
Route::get('get-lecturas-serie/{brazo}/{tramo}/{ubicacion}/{num_serie}/{cantidad?}', [EscaneosController::class, 'getLecturasByNumSerie'])->name('get-lecturas-serie');

// ===============================================================================
// Sincronizar
// ===============================================================================
Route::post('sincronizar/by-serial', [SincronizacionController::class, 'syncBySerial'])->name('sincronizar.by-serial');
Route::post('sincronizar/by-difference', [SincronizacionController::class, 'syncByDifference'])->name('sincronizar.by-difference');

