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
        Schema::create('diagnosticos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grupos_id')->constrained('grupos')->onDelete('cascade');
            $table->foreignId('periodo_id')->constrained('periodo')->onDelete('cascade');
            $table->text('problemarios')->nullable();
            $table->text('solucion')->nullable();
            $table->text('objetivos')->nullable();
            $table->date('fecha_realizacion')->nullable();
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
        Schema::dropIfExists('diagnosticos');
    }
};