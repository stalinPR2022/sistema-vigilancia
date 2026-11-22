<?php

namespace App\Services;

use App\Models\Alerta;

class ControladorActuadorSimulado
{
    public function activar(Alerta $alerta): void
    {
        // Simular la activacion de la alarma
        $alerta->alarma_activada = true;

        // Registrar el resultado de la activacion
        $alerta->save();
    }
}
