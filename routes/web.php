<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\SimulacionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/horarios', [HorarioController::class, 'index'])
    ->name('horarios.index');

Route::post('/horarios', [HorarioController::class, 'guardar'])
    ->name('horarios.guardar');


//Rutas de la simulación
Route::get('/simulacion', [SimulacionController::class, 'index'])
    ->name('simulacion.index');

Route::post('/simulacion', [SimulacionController::class, 'simular'])
    ->name('simulacion.ejecutar');