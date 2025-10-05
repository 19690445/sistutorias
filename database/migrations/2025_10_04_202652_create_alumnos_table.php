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
         Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido')->nullable();
            $table->string('correo_electronico')->unique();
            $table->string('password');
            $table->string('foto_perfil')->nullable();
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            $table->enum('rol', ['admin', 'coordinador', 'tutor', 'tutorado'])->default('tutorado');
            $table->timestamp('ultimo_acceso')->nullable();
            $table->timestamps(); // crea created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnos');
    }
};
