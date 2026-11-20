<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('horarios_permitidos', function (Blueprint $table) {
            $table->increments('id_horario');
            $table->unsignedInteger('id_puerta');
            $table->smallInteger('dia_semana');
            $table->time('hora_inicio');
            $table->time('hora_fin');

            $table->foreign('id_puerta')
                ->references('id_puerta')
                ->on('puertas');

            $table->unique(['id_puerta', 'dia_semana']);
        });

        DB::statement(
            'ALTER TABLE horarios_permitidos
             ADD CONSTRAINT chk_dia_semana
             CHECK (dia_semana BETWEEN 1 AND 7)'
        );

        DB::statement(
            'ALTER TABLE horarios_permitidos
             ADD CONSTRAINT chk_horas
             CHECK (hora_inicio < hora_fin)'
        );
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios_permitidos');
    }
};
