<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Puerta extends Model
{
    protected $table = 'puertas';

    protected $primaryKey = 'id_puerta';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
        'activa',
    ];

    //Obtener los horarios permitidos de la puerta
    public function horarios(): HasMany
    {
        return $this->hasMany(
            HorarioPermitido::class,
            'id_puerta',
            'id_puerta'
        );
    }

    //Obtener los eventos generados por la puerta.
    public function eventos(): HasMany
    {
        return $this->hasMany(
            Evento::class,
            'id_puerta',
            'id_puerta'
        );
    }

}