<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notificacion extends Model
{
    protected $table = 'notificaciones';

    protected $primaryKey = 'id_notificacion';

    public $timestamps = false;

    protected $fillable = [
        'id_alerta',
        'canal',
        'destinatario',
        'estado',
        'fecha_hora_envio',
        'detalle_resultado',
    ];

    protected function casts(): array
    {
        return [
            'fecha_hora_envio' => 'datetime',
        ];
    }

    public function alerta(): BelongsTo
    {
        return $this->belongsTo(
            Alerta::class,
            'id_alerta',
            'id_alerta'
        );
    }
}
