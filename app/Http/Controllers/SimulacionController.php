<?php

namespace App\Http\Controllers;

use App\Models\Puerta;
use App\Services\EvaluadorHorarios;
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
        GestorEventos $gestorEventos,
        EvaluadorHorarios $evaluador
    ) {
        $puerta = Puerta::where('nombre', 'Puerta principal')
            ->where('activa', true)
            ->firstOrFail();

        // Generar apertura simulada
        $datos = $sensor->generarApertura($puerta);

        // Registrar y evaluar el evento
        $evento = $gestorEventos->registrar($datos, $evaluador);

        return redirect()
            ->route('simulacion.index')
            ->with('evento', [
                'id_evento' => $evento->id_evento,
                'id_puerta' => $evento->id_puerta,
                'tipo_evento' => $evento->tipo_evento,
                'fecha_hora' => $evento->fecha_hora
                    ->copy()
                    ->setTimezone('America/El_Salvador')
                    ->format('d/m/Y H:i:s'),
                'clasificacion' => $evento->clasificacion,
            ]);
    }
}
