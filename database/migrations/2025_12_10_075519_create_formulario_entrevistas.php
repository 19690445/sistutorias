<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('formulario_entrevistas', function (Blueprint $table) {
            $table->id();
            
            // ========== SECCIÓN 1: DATOS PERSONALES ==========
            $table->string('carrera', 50);
            $table->string('numero_control', 20);
            $table->string('nombre_completo', 200);
            $table->integer('edad');
            $table->enum('genero', ['masculino', 'femenino', 'otro', 'prefiero_no_decir']);
            $table->enum('estado_civil', ['soltero', 'casado', 'union_libre', 'divorciado', 'viudo', 'otro']);
            $table->date('fecha_nacimiento');
            $table->string('lugar_nacimiento', 200);
            $table->string('telefono_celular', 15);
            $table->string('telefono_hogar', 15)->nullable();
            $table->boolean('habla_lengua_indigena')->default(false);
            
            // ========== SECCIÓN 2: SITUACIÓN LABORAL ==========
            $table->enum('has_trabajado', ['si', 'no']);
            $table->boolean('trabaja_actualmente')->default(false);
            $table->enum('horas_trabajo_semana', ['1-6', '7-12', '13-20', '21-30', '31-40', '40+'])->nullable();
            $table->text('motivo_trabajo')->nullable();
            
            // ========== SECCIÓN 3: DATOS FAMILIARES ==========
            $table->string('nombre_padre', 200);
            $table->string('nombre_madre', 200);
            $table->boolean('padre_vive')->default(true);
            $table->boolean('madre_vive')->default(true);
            
            $table->enum('ocupacion_padre', [
                'empleado_publico', 'empleado_privado', 'empleada_domestica', 'empresario',
                'operario', 'director_gerente', 'tecnico', 'jubilado', 'trabajador_campo',
                'comerciante', 'labores_hogar', 'otra', 'no_trabaja'
            ]);
            
            $table->enum('ocupacion_madre', [
                'empleado_publico', 'empleado_privado', 'empleada_domestica', 'empresario',
                'operario', 'director_gerente', 'tecnico', 'jubilado', 'trabajador_campo',
                'comerciante', 'labores_hogar', 'otra', 'no_trabaja'
            ]);
            
            $table->string('telefono_padre', 15)->nullable();
            $table->string('telefono_madre', 15)->nullable();
            
            // ========== SECCIÓN 4: SITUACIÓN SOCIOECONÓMICA ==========
            $table->json('nivel_educativo_familiar')->nullable();
            $table->string('zona_residencia', 50);
            $table->string('tipo_vivienda', 50);
            $table->integer('tiempo_recorrido_escuela');
            $table->json('servicios_vivienda')->nullable();
            $table->json('financiamiento_estudios')->nullable();
            $table->enum('ingreso_familiar_mensual', [
                'menos_3000', '3001_6000', '6001_10000', '10001_15000',
                '15001_20000', '20001_30000', 'mas_30001'
            ]);
            
            // ========== SECCIÓN 5: ORIENTACIÓN PROFESIONAL ==========
            $table->json('factores_eleccion_carrera')->nullable();
            $table->json('razones_dejar_estudiar')->nullable();
            $table->text('vision_mundo_laboral')->nullable();
            
            // ========== SECCIÓN 6: RENDIMIENTO ACADÉMICO ==========
            $table->boolean('ha_estado_becado')->default(false);
            $table->string('tipo_beca', 100)->nullable();
            $table->decimal('promedio_bachillerato', 4, 2)->nullable();
            $table->json('evaluacion_materias')->nullable();
            $table->json('necesita_ayuda_materias')->nullable();
            $table->boolean('puede_asesorar_companeros')->default(false);
            
            // ========== SECCIÓN 7: SALUD ==========
            $table->boolean('enfermedad_cronica')->default(false);
            $table->string('enfermedad_cronica_especifica', 300)->nullable();
            $table->boolean('toma_medicamento')->default(false);
            $table->string('tipo_medicamentos', 500)->nullable();
            $table->json('condiciones_salud')->nullable();
            $table->string('institucion_salud', 100)->nullable();
            
            // ========== SECCIÓN 8: ASPECTOS PERSONALES ==========
            $table->json('caracteristicas_personales')->nullable();
            $table->json('relacion_con_padres')->nullable();
            $table->json('actividades_tiempo_libre')->nullable();
            $table->text('meta_vida')->nullable();
            
            // ========== METADATOS ==========
            $table->timestamp('fecha_llenado')->useCurrent();
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent', 500)->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('formulario_entrevistas');
    }
};