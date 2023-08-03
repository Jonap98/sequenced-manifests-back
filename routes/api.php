<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\manifiestos\seleccion\SeccionesController;
use App\Http\Controllers\manifiestos\EscaneosController;

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

// ===============================================================================
// Manifiestos
// ===============================================================================
Route::get('get-lecturas/{brazo}/{tramo}', [EscaneosController::class, 'getLecturas'])->name('get-lecturas');
