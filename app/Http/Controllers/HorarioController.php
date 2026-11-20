<?php

namespace App\Http\Controllers;

use App\Models\Puerta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HorarioController extends Controller
{
    // Mostrar los horarios configurados
    public function index()
    {
        $puerta = Puerta::where('nombre', 'Puerta principal')
            ->firstOrFail();

        $horarios = $puerta->horarios()
            ->orderBy('dia_semana')
            ->get();

        return view('horarios.index', compact('puerta', 'horarios'));
    }

    // Guardar o actualizar la configuración
    public function guardar(Request $request)
    {
        $datos = $request->validate([
            'dias' => ['required', 'array', 'min:1'],
            'dias.*' => ['required', 'integer', 'between:1,7', 'distinct'],
            'hora_inicio' => ['required', 'date_format:H:i'],
            'hora_fin' => ['required', 'date_format:H:i', 'after:hora_inicio'],
        ]);

        $puerta = Puerta::where('nombre', 'Puerta principal')
            ->firstOrFail();

        DB::transaction(function () use ($puerta, $datos) {

            // Eliminar los días que fueron desmarcados
            $puerta->horarios()
                ->whereNotIn('dia_semana', $datos['dias'])
                ->delete();

            // Registrar o actualizar cada día seleccionado
            foreach ($datos['dias'] as $dia) {
                $puerta->horarios()->updateOrCreate(
                    ['dia_semana' => $dia],
                    [
                        'hora_inicio' => $datos['hora_inicio'],
                        'hora_fin' => $datos['hora_fin'],
                    ]
                );
            }
        });

        return redirect()
            ->route('horarios.index')
            ->with('success', 'Horarios guardados correctamente.');
    }
}
