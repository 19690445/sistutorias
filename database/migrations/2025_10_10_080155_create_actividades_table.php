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
        Schema::create('actividades_derivadas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diagnosticos_id')->constrained('diagnosticos')->onDelete('cascade'); 
            $table->string('sesion', 50)->nullable();
            $table->date('fecha_creacion')->nullable();
            $table->string('eje', 100)->nullable();
            $table->string('tema', 150);
            $table->text('actividades')->nullable();
            $table->text('materiales_usar')->nullable();
            $table->enum('estado', ['pendiente', 'en_proceso', 'completado'])->default('pendiente');
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actividades_derivadas');
    }
};

