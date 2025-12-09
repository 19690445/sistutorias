<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('asistencias', function (Blueprint $table) {
            $table->foreignId('tutores_id')->nullable()->constrained('tutores')->onDelete('cascade');
            $table->foreignId('estudiantes_id')->nullable()->constrained('estudiantes')->onDelete('cascade');
            $table->foreignId('grupo_id')->nullable()->constrained('grupos')->onDelete('cascade');
            $table->foreignId('periodo_id')->nullable()->constrained('periodo')->onDelete('cascade');
            $table->integer('sesion')->nullable();
            $table->date('fecha')->nullable();
            $table->enum('estado', ['si', 'no', 'np', 'justificado'])->default('si');
            $table->text('observaciones')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('asistencias', function (Blueprint $table) {
            $table->dropForeign(['tutores_id']);
            $table->dropForeign(['estudiantes_id']);
            $table->dropForeign(['grupo_id']);
            $table->dropForeign(['periodo_id']);
            
            $table->dropColumn([
                'tutores_id',
                'estudiantes_id',
                'grupo_id',
                'periodo_id',
                'sesion',
                'fecha',
                'estado',
                'observaciones'
            ]);
        });
    }
};