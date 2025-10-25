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
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tutores_id')->constrained('tutores')->onDelete('cascade');     
            $table->foreignId('estudiantes_id')->constrained('estudiantes')->onDelete('cascade');     
            $table->foreignId('periodo_id')->constrained('periodo')->onDelete('cascade');
            $table->integer('sesion');
            $table->date('fecha');
            $table->enum('estado', ['si', 'no', 'np', 'justificado'])
                  ->default('si');
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
