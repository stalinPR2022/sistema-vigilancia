<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notificaciones', function (Blueprint $table) {

            $table->increments('id_notificacion');

            $table->unsignedInteger('id_alerta');

            $table->string('canal', 20);

            $table->string('destinatario', 255);

            $table->string('estado', 20);

            $table->timestampTz('fecha_hora_envio')->nullable();

            $table->text('detalle_resultado')->nullable();

            $table->foreign('id_alerta')
                ->references('id_alerta')
                ->on('alertas');
        });

        DB::statement("
            ALTER TABLE notificaciones
            ADD CONSTRAINT chk_notificaciones_canal
            CHECK (canal IN ('SMTP', 'TELEGRAM'))
        ");

        DB::statement("
            ALTER TABLE notificaciones
            ADD CONSTRAINT chk_notificaciones_estado
            CHECK (estado IN ('PENDIENTE', 'ENVIADO', 'FALLIDO'))
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('notificaciones');
    }
};
