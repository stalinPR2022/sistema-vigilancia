<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Evento extends Model
{
    protected $table = 'eventos';

    protected $primaryKey = 'id_evento';

    public $timestamps = false;

    protected $fillable = [
        'id_puerta',
        'tipo_evento',
        'fecha_hora',
        'clasificacion',
    ];

    protected function casts(): array
    {
        return [
            'fecha_hora' => 'datetime',
        ];
    }

    //Funcion de la puerta
    public function puerta(): BelongsTo
    {
        return $this->belongsTo(
            Puerta::class,
            'id_puerta',
            'id_puerta'
        );
    }

    //funciona de la alerta
    public function alerta(): HasOne
    {
        return $this->hasOne(
            Alerta::class,
            'id_evento',
            'id_evento'
        );
    }

}
