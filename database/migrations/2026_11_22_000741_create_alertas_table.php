<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alertas', function (Blueprint $table) {

            $table->increments('id_alerta');

            $table->unsignedInteger('id_evento')->unique();

            $table->timestampTz('fecha_hora');

            $table->text('mensaje');

            $table->boolean('alarma_activada')
                ->default(false);

            $table->foreign('id_evento')
                ->references('id_evento')
                ->on('eventos');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alertas');
    }
};
