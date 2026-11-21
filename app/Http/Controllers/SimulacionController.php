<?php

namespace App\Http\Controllers;

use App\Models\Puerta;
use App\Services\SensorPuertaSimulado;

class SimulacionController extends Controller
{
    public function index()
    {
        $puerta = Puerta::where('nombre', 'Puerta principal')
            ->firstOrFail();

        return view('simulacion.index', compact('puerta'));
    }

    public function simular(SensorPuertaSimulado $sensor)
    {
        $puerta = Puerta::where('nombre', 'Puerta principal')
            ->where('activa', true)
            ->firstOrFail();

        $evento = $sensor->generarApertura($puerta);

        return redirect()
            ->route('simulacion.index')
            ->with('evento', $evento);
    }
}
