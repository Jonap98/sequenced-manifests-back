<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\manifiestos\VisualizacionController;
use App\Http\Controllers\manifiestos\EscaneosController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('visualizacion', [VisualizacionController::class, 'index'])->name('visualizacion');
Route::get('get-lecturas', [EscaneosController::class, 'getLecturas'])->name('get-lecturas');

