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
        Schema::create('grupos', function (Blueprint $table) {
            $table->id();
            $table->string('clave_grupo', 20)->unique();
            $table->string('nombre_grupo', 100);
            $table->foreignId('tutores_id')->constrained('tutores')->onDelete('cascade');
            $table->foreignId('periodo_id')->constrained('periodo')->onDelete('cascade');
            $table->string('carrera', 100);
            $table->integer('semestre');
            $table->string('aula', 50)->nullable();
            $table->string('horario', 100)->nullable();
            $table->integer('capacidad_salon')->nullable();
            $table->enum('modalidad', ['presencial', 'virtual', 'mixta'])->default('presencial');
            $table->enum('turno', ['matutino', 'intermedio', 'vespertino'])->default('matutino');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grupos');
    }
};
