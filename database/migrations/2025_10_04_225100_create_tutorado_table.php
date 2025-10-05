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
        Schema::create('tutorados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estudiante_id')->constrained('estudiantes')->onDelete('cascade');
            $table->foreignId('periodo_id')->constrained('periodos')->onDelete('cascade');
            $table->foreignId('tutores_id')->constrained('tutores')->onDelete('cascade');
            $table->string('nombre');
            $table->string('apellido_paterno');
            $table->string('apellido_materno')->nullable();
            $table->string('matricula')->unique();
            $table->string('carrera');
            $table->integer('semestre')->nullable();
            $table->integer('edad')->nullable();
            $table->enum('genero', ['masculino','femenino','otro'])->nullable();
            $table->string('correo_electronico')->nullable();
            $table->string('telefono')->nullable();
            $table->text('direccion')->nullable();
            $table->enum('estado', ['activo','baja_temporal','baja_definitiva','egresado'])->default('activo');
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tutorado');
    }
};
