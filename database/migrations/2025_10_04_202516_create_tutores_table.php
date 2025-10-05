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
       Schema::create('tutores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');
            $table->string('nombre');
            $table->string('apellido')->nullable();
            $table->string('rfc')->nullable();
            $table->string('correo_electronico')->unique();
            $table->string('telefono')->nullable();
            $table->string('departamento')->nullable();
            $table->foreignId('grupo_id')->nullable()->constrained('grupos')->onDelete('set null');
            $table->foreignId('periodo_id')->nullable()->constrained('periodos')->onDelete('set null');
            $table->enum('estatus', ['activo', 'inactivo'])->default('activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tutores');
    }
};
