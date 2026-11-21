<?php

namespace App\Services;

use App\Models\Evento;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;

class GestorEventos
{
    public function registrar(
        array $datos,
        EvaluadorHorarios $evaluador
    ): Evento {
        return DB::transaction(function () use ($datos, $evaluador) {

            // Convertir explícitamente la fecha a UTC
            $fechaUtc = CarbonImmutable::parse(
                $datos['fecha_hora']
            )->utc()->format('Y-m-d H:i:s');

            // Registrar el evento con fecha UTC
            $evento = Evento::create([
                'id_puerta' => $datos['id_puerta'],
                'tipo_evento' => $datos['tipo_evento'],
                'fecha_hora' => $fechaUtc,
                'clasificacion' => 'PENDIENTE',
            ]);

            // Evaluar utilizando la hora local de El Salvador
            $clasificacion = $evaluador->evaluar($evento);

            // Actualizar el evento
            $evento->clasificacion = $clasificacion;
            $evento->save();

            return $evento;
        });
    }
}
