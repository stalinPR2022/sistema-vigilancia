<?php

namespace App\Services;

use App\Models\Evento;
use App\Models\HorarioPermitido;

class EvaluadorHorarios
{
    public function evaluar(Evento $evento): string
    {
        // Convertir la fecha del evento a la hora local
        $fechaLocal = $evento->fecha_hora
            ->copy()
            ->setTimezone('America/El_Salvador');

        // Obtener el día: lunes = 1, domingo = 7
        $diaSemana = $fechaLocal->dayOfWeekIso;

        // Obtener la hora de apertura
        $horaEvento = $fechaLocal->format('H:i:s');

        // Consultar el horario de la puerta para ese día
        $horario = HorarioPermitido::where(
            'id_puerta',
            $evento->id_puerta
        )
        ->where('dia_semana', $diaSemana)
        ->first();

        // Si no existe un horario, la apertura es anómala
        if (!$horario) {
            return 'ANOMALO';
        }

        // Normalizar horas para realizar la comparación
        $horaInicio = substr($horario->hora_inicio, 0, 8);
        $horaFin = substr($horario->hora_fin, 0, 8);

        // Evaluar si la apertura está dentro del horario
        if (
            $horaEvento >= $horaInicio &&
            $horaEvento < $horaFin
        ) {
            return 'AUTORIZADO';
        }

        return 'ANOMALO';
    }
}
