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
        Schema::create('individuales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periodo_id')->constrained('periodo')->onDelete('cascade');               
            $table->foreignId('tutores_id')->constrained('tutores')->onDelete('cascade');
            $table->foreignId('estudiantes_id')->constrained('estudiantes')->onDelete('cascade');   
            $table->enum('requiere_canalizacion', ['si', 'no'])->default('no')
                ->comment('Si es "si", el tutorado podrá acceder a la encuesta de canalización'); 
            $table->text('motivo')->nullable();
            $table->enum('estado', ['pendiente', 'en_proceso', 'completado'])
                  ->default('pendiente');

            // ⏱️ Fechas automáticas
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('individuales');
    }
};
