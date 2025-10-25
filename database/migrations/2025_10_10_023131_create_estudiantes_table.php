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
            $table->foreignId('users_id')->nullable()->constrained('users');
            $table->string('matricula', 20)->unique();
            $table->string('nombre', 100);
            $table->string('apellidos', 100);
            $table->string('curp', 18)->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->enum('genero', ['masculino', 'femenino', 'otro'])->nullable();
            $table->string('correo_institucional', 150)->unique();
            $table->string('telefono_celular', 20)->nullable();
            $table->text('domicilio')->nullable();
            $table->string('carrera', 100)->nullable();
            $table->integer('semestre')->nullable();
            $table->enum('estado', ['activo', 'baja_temporal', 'baja_definitiva', 'egresado'])->default('activo');
            $table->date('fecha_ingreso')->nullable();
            $table->date('fecha_egreso')->nullable();
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
