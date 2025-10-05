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
        Schema::create('indicadores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diagnostico_id')->constrained('diagnosticos')->onDelete('cascade');
            $table->text('causa');
            $table->string('clave_indicadora', 50);
            $table->text('descripcion')->nullable();
            $table->string('meta', 100)->nullable();
            $table->date('fecha_registro')->nullable();
            $table->foreignId('responsable_id')->nullable()->constrained('tutores')->onDelete('set null');
            $table->enum('estado', ['pendiente','en_proceso','completado'])->default('pendiente');
            $table->text('notas')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indicadores');
    }
};
