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
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumnos_id')->constrained('alumnos')->onDelete('cascade');
            $table->foreignId('grupo_id')->nullable()->constrained('grupos')->onDelete('set null');
            $table->foreignId('tutores_id')->nullable()->constrained('tutores')->onDelete('set null');
            $table->foreignId('periodo_id')->nullable()->constrained('periodos')->onDelete('set null');
            $table->string('matricula')->unique();
            $table->string('nombre');
            $table->string('apellido_paterno');
            $table->string('apellido_materno')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->enum('genero', ['masculino', 'femenino', 'otro'])->nullable();
            $table->string('correo_institucional')->nullable();
            $table->string('telefono')->nullable();
            $table->text('direccion')->nullable();
            $table->string('carrera')->nullable();
            $table->integer('semestre')->nullable();
            $table->decimal('promedio', 4, 2)->nullable();
            $table->enum('estatus', ['activo', 'baja_temporal', 'baja_definitiva', 'egresado'])->default('activo');
            $table->date('fecha_ingreso')->nullable();
            $table->date('fecha_egreso')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudiantes');
    }
};
