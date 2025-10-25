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
        Schema::create('pats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tutores_id') ->constrained('tutores')->onDelete('cascade');
            $table->foreignId('grupos_id')->constrained('grupos')->onDelete('cascade');
            $table->foreignId('periodo_id')->constrained('periodo')->onDelete('cascade'); 
            $table->string('actividad', 150);
            $table->string('responsable', 100)->nullable(); // Tutor o estudiante
            $table->string('semana_planeada', 50)->nullable();
            $table->string('semana_real', 50)->nullable();
            $table->enum('estado', ['pendiente', 'en_proceso', 'completado'])->default('pendiente');   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pats');
    }
};

