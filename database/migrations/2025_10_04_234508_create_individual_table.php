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
        Schema::create('individual', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periodo_id')->constrained('periodos')->onDelete('cascade');
            $table->foreignId('tutor_id')->constrained('tutores')->onDelete('cascade');
            $table->foreignId('tutorado_id')->constrained('tutorados')->onDelete('cascade');
            $table->enum('requiere_canalizacion', ['si','no'])->default('no');
            $table->text('motivo')->nullable();
            $table->text('observaciones')->nullable();
            $table->enum('estado', ['pendiente','en_proceso','completado'])->default('pendiente');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('individual');
    }
};
