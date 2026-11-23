<?php

namespace App\Http\Controllers;

use App\Models\Evento;

class HistorialController extends Controller
{
    // Consultar los eventos registrados
    public function index()
    {
        $eventos = Evento::with(['puerta', 'alerta'])
            ->orderByDesc('id_evento')
            ->paginate(10);

        return view('historial.index', compact('eventos'));
    }

    // Consultar el detalle de un evento
    public function show(int $id)
    {
        $evento = Evento::with(['puerta', 'alerta'])
            ->findOrFail($id);

        return view('historial.show', compact('evento'));
    }
}
