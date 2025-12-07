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
        Schema::create('tutores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')->constrained('users')->onDelete('cascade');
            $table->string('nombre', 100);
            $table->string('apellidos', 100);
            $table->string('curp', 18)->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->enum('sexo', ['masculino', 'femenino', 'otro'])->nullable();
            $table->string('correo_electronico', 100)->unique();
            $table->string('telefono', 20)->nullable();
            $table->string('departamento', 100)->nullable();
            $table->string('rfc', 13)->nullable();
            $table->string('nivel_estudios', 100)->nullable();
            $table->text('descripcion_estudios')->nullable();
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            $table->string('foto_perfil')->nullable();
            $table->timestamp('fecha_registro')->useCurrent();
            $table->timestamp('fecha_actualizacion')->useCurrent()->useCurrentOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tutores');
    }
};

