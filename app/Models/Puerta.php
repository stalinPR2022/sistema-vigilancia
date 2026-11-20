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

    public function horarios(): HasMany
    {
        return $this->hasMany(
            HorarioPermitido::class,
            'id_puerta',
            'id_puerta'
        );
    }
}