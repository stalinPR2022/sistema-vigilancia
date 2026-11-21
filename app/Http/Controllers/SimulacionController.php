<?php

namespace App\Http\Controllers;

use App\Models\Puerta;
use App\Services\GestorEventos;
use App\Services\SensorPuertaSimulado;

class SimulacionController extends Controller
{
    public function index()
    {
        $puerta = Puerta::where('nombre', 'Puerta principal')
            ->firstOrFail();

        return view('simulacion.index', compact('puerta'));
    }

    public function simular(
        SensorPuertaSimulado $sensor,
        GestorEventos $gestorEventos
    ) {
        $puerta = Puerta::where('nombre', 'Puerta principal')
            ->where('activa', true)
            ->firstOrFail();

        // 1. El sensor genera los datos de apertura
        $datos = $sensor->generarApertura($puerta);

        // 2. El gestor registra el evento en PostgreSQL
        $evento = $gestorEventos->registrar($datos);

        // 3. Mostrar el resultado de la simulación
        return redirect()
            ->route('simulacion.index')
            ->with('evento', [
                'id_evento' => $evento->id_evento,
                'id_puerta' => $evento->id_puerta,
                'tipo_evento' => $evento->tipo_evento,
                'fecha_hora' => $evento->fecha_hora->toIso8601String(),
                'clasificacion' => $evento->clasificacion,
            ]);
    }
}
