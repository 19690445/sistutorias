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
            $table->string('clave', 20)->unique();
            $table->string('nombre', 100)->nullable();
            $table->foreignId('tutores_id')->constrained('tutores')->onDelete('cascade');
            $table->foreignId('periodo_id')->constrained('periodos')->onDelete('cascade');
            $table->string('carrera', 100);
            $table->integer('semestre')->nullable();
            $table->string('aula', 50)->nullable();
            $table->string('horario', 100)->nullable();
            $table->integer('cupo')->nullable();
            $table->enum('modalidad', ['presencial', 'virtual', 'mixta'])->default('presencial');
            $table->enum('turno', ['matutino', 'vespertino', 'nocturno'])->default('matutino');
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grupo');
    }
};
