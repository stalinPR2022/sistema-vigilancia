<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HorarioController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/horarios', [HorarioController::class, 'index'])
    ->name('horarios.index');

Route::post('/horarios', [HorarioController::class, 'guardar'])
    ->name('horarios.guardar');