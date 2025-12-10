<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('canalizaciones', function (Blueprint $table) {
            
            $table->string('tipo_atencion', 100)->change();
        });
    }

    public function down(): void
    {
        Schema::table('canalizaciones', function (Blueprint $table) {
            
            $table->enum('tipo_atencion', [
                'Asesoria Individual',
                'Salud y hábitos alimenticios',
                'Consumo de substancias tóxicas',
                'Problemas emocionales',
                'Problemas familiares',
                'Problemas académicos',
                'Manejo de sexualidad y relaciones de pareja',
                'Otros (especifique)',
            ])->change();
        });
    }
};