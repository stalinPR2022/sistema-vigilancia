<?php

namespace App\Services;

use App\Models\Evento;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;

class GestorEventos
{
    public function registrar(
        array $datos,
        EvaluadorHorarios $evaluador,
        GeneradorAlertas $generadorAlertas,
        ControladorActuadorSimulado $actuador
    ): Evento {
        return DB::transaction(function () use (
            $datos,
            $evaluador,
            $generadorAlertas,
            $actuador
        ) {
            // 1. Convertir la fecha a UTC
            $fechaUtc = CarbonImmutable::parse(
                $datos['fecha_hora']
            )->utc()->format('Y-m-d H:i:s');

            // 2. Registrar el evento
            $evento = Evento::create([
                'id_puerta' => $datos['id_puerta'],
                'tipo_evento' => $datos['tipo_evento'],
                'fecha_hora' => $fechaUtc,
                'clasificacion' => 'PENDIENTE',
            ]);

            // 3. Evaluar el horario
            $evento->clasificacion = $evaluador->evaluar($evento);
            $evento->save();

            // 4. Generar alerta si es anomalo
            $alerta = $generadorAlertas->generar($evento);

            // 5. Activar la alarma simulada
            if ($alerta !== null) {
                $actuador->activar($alerta);
            }

            return $evento;
        });
    }
}
