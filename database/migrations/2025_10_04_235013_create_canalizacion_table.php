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
        Schema::create('canalizadores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('individual_id')->constrained('individual')->onDelete('cascade');
            $table->enum('tipo_atencion', ['psicologica','academica','orientacion','otra']);
            $table->text('causa_problema')->nullable();
            $table->text('acciones_sugeridas')->nullable();
            $table->date('primera_sesion_propuesta')->nullable();
            $table->date('primera_sesion_real')->nullable();
            $table->text('seguimiento_tutor')->nullable();
            $table->enum('estado', ['pendiente','en_proceso','finalizado'])->default('pendiente');
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('canalizacion');
    }
};
