<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HorarioPermitido extends Model
{
    protected $table = 'horarios_permitidos';

    protected $primaryKey = 'id_horario';

    public $timestamps = false;

    protected $fillable = [
        'id_puerta',
        'dia_semana',
        'hora_inicio',
        'hora_fin',
    ];

    public function puerta(): BelongsTo
    {
        return $this->belongsTo(
            Puerta::class,
            'id_puerta',
            'id_puerta'
        );
    }
}