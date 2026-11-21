<?php

namespace App\Services;

use App\Models\Evento;

class GestorEventos
{
    public function registrar(array $datos): Evento
    {
        return Evento::create([
            'id_puerta' => $datos['id_puerta'],
            'tipo_evento' => $datos['tipo_evento'],
            'fecha_hora' => $datos['fecha_hora'],
            'clasificacion' => 'PENDIENTE',
        ]);
    }
}
