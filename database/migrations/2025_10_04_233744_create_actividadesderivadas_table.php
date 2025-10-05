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
        Schema::create('actividaderivada', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diagnostico_id')->constrained('diagnosticos')->onDelete('cascade');
            $table->string('sesion', 50)->nullable();
            $table->date('creacion_act')->nullable();
            $table->string('eje', 100)->nullable();
            $table->string('tema', 150)->nullable();
            $table->text('actividades')->nullable();
            $table->text('materiales_usar')->nullable();
            $table->foreignId('responsable_id')->nullable()->constrained('tutores')->onDelete('set null');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actividadesderivadas');
    }
};
