<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('canalizaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('individuales_id')->constrained('individuales')->onDelete('cascade');
            $table->enum('tipo_atencion', [
                'servicios psicologicos',
                'servicios de salud',
                'adicciones',
                'beca manutencion',
                'beca transporte',
                'beca alimentacion',
                'asesoria academica',
                'asesoria procesos academicos/administrativos',
                'aptitudes sobresalientes'
            ]);
            $table->text('causa_problema')->nullable();
            $table->text('acciones_sugeridas')->nullable();
            $table->date('primera_sesion_propuesta')->nullable();
            $table->date('primera_sesion_real')->nullable();
            $table->text('seguimiento_tutor')->nullable();
            $table->enum('estado', ['pendiente', 'en_proceso', 'finalizado'])->default('pendiente');
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('canalizaciones');
    }
};

