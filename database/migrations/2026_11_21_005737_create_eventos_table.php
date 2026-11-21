<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->increments('id_evento');

            $table->unsignedInteger('id_puerta');

            $table->string('tipo_evento', 30)
                ->default('APERTURA');

            $table->timestampTz('fecha_hora');

            $table->string('clasificacion', 20)
                ->default('PENDIENTE');

            $table->foreign('id_puerta')
                ->references('id_puerta')
                ->on('puertas');
        });

        DB::statement("
            ALTER TABLE eventos
            ADD CONSTRAINT chk_tipo_evento
            CHECK (tipo_evento IN ('APERTURA'))
        ");

        DB::statement("
            ALTER TABLE eventos
            ADD CONSTRAINT chk_clasificacion
            CHECK (
                clasificacion IN (
                    'PENDIENTE',
                    'AUTORIZADO',
                    'ANOMALO'
                )
            )
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};

