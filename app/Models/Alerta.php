<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Alerta extends Model
{
    protected $table = 'alertas';

    protected $primaryKey = 'id_alerta';

    public $timestamps = false;

    protected $fillable = [
        'id_evento',
        'fecha_hora',
        'mensaje',
        'alarma_activada',
    ];

    protected function casts(): array
    {
        return [
            'fecha_hora' => 'datetime',
            'alarma_activada' => 'boolean',
        ];
    }

    public function evento(): BelongsTo
    {
        return $this->belongsTo(
            Evento::class,
            'id_evento',
            'id_evento'
        );
    }
}
