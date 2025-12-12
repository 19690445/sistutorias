<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminTutoradoController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\TutorDashboardController;
use App\Http\Controllers\TutoradoController;
use App\Http\Controllers\TutoradoDashboardController;
use App\Http\Controllers\DiagnosticoController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\PeriodoController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\CanalizacionController;
use App\Http\Controllers\PatController;
use App\Http\Controllers\SemanaController;
use App\Http\Controllers\IndividualController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\FormularioEntrevistaController;
use App\Http\Controllers\IndicadorController;


/*
RUTA PRINCIPAL
*/
Route::get('/', fn() => view('welcome'));
Auth::routes();

/*
TUTORADO
*/
Route::middleware(['auth', 'role:tutorado'])->group(function () {

    Route::get('/tutorado/dashboard', [TutoradoDashboardController::class, 'index'])
        ->name('tutorado.dashboard');

    Route::post('/tutorado/update', [TutoradoController::class, 'update'])
        ->name('tutorado.update');

    Route::get('/mi-informacion', [App\Http\Controllers\TutoradoController::class, 'show'])
        ->name('tutorado.show');

    Route::get('/tutorado/mi-perfil', [App\Http\Controllers\TutoradoController::class, 'show'])
        ->name('tutorado.perfil');

    Route::get('/tutorado/mi-perfil', [TutoradoController::class, 'show'])->name('tutorado.perfil');
    Route::get('/tutorado/editar-perfil', [TutoradoController::class, 'edit'])->name('tutorado.editPerfil');
    Route::put('/tutorado/actualizar-perfil', [TutoradoController::class, 'update'])->name('tutorado.updatePerfil');


});

/*
ADMIN
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')->name('admin.')
    ->group(function () {

        Route::get('/dashboard', fn() => view('admin.dashboard'))
            ->name('dashboard');

        Route::get('/register', [App\Http\Controllers\Auth\RegisteredUserController::class, 'create'])
            ->name('register');
        Route::post('/register', [App\Http\Controllers\Auth\RegisteredUserController::class, 'store'])
            ->name('register.store');

        Route::resource('users', AdminUserController::class);
        Route::resource('tutorados', AdminTutoradoController::class);

        // Configuración
        Route::get('/configuracion', [ConfiguracionController::class, 'index'])->name('configuracion.index');
        Route::get('/configuracion/create', [ConfiguracionController::class, 'create'])->name('configuracion.create');
        Route::post('/configuracion', [ConfiguracionController::class, 'store'])->name('configuracion.store');

        // PERIODOS
        Route::resource('periodos', PeriodoController::class)->only([
            'index','create','store'
        ]);
    });

/*
DOCENTE
*/
Route::middleware(['auth', 'role:docente'])->group(function () {

    Route::get('/docente/dashboard', fn() => view('docente.dashboard'))
        ->name('docente.dashboard');

    Route::get('/dashboard/tutor', [TutorDashboardController::class, 'index'])
        ->name('dashboard.tutor');
});

/*
COORDINADOR
*/
Route::middleware(['auth', 'role:coordinador'])
    ->prefix('coordinador')->name('coordinador.')
    ->group(function () {

        Route::get('/dashboard', fn() => view('coordinador.dashboard'))
            ->name('dashboard');

        Route::get('/tutorados', [AdminTutoradoController::class, 'index'])->name('tutorados.index');
        Route::get('/tutorados/{id}/edit', [AdminTutoradoController::class, 'edit'])->name('tutorados.edit');
        Route::put('/tutorados/{id}', [AdminTutoradoController::class, 'update'])->name('tutorados.update');

        Route::resource('periodos', PeriodoController::class)->only([
            'index','create','store'
        ]);
});

/*
TUTORES
*/
Route::middleware(['auth', 'role:admin,coordinador,docente'])->group(function () {

    Route::resource('tutores', TutorController::class)
        ->parameters([
            'tutores' => 'tutor' 
        ]);

    Route::get('mi-perfil', [TutorController::class, 'perfil'])
        ->name('tutores.perfil');

    Route::put('mi-perfil', [TutorController::class, 'actualizarPerfil'])
        ->name('tutores.actualizarPerfil');
});

    /*
    DIAGNÓSTICOS
    */
    // Rutas para Diagnósticos
    Route::resource('diagnosticos', DiagnosticoController::class);
    Route::get('diagnosticos/{diagnostico}/detalles', [DiagnosticoController::class, 'detalles'])->name('diagnosticos.detalles');

    /*
    INDICADO
    */
    Route::prefix('indicadores')->name('indicadores.')->group(function () {
    Route::get('/{indicador}/edit', [IndicadorController::class, 'edit'])->name('edit');
    Route::put('/{indicador}', [IndicadorController::class, 'update'])->name('update');
    Route::delete('/{indicador}', [IndicadorController::class, 'destroy'])->name('destroy');
});

// ===== GRUPOS =====

Route::prefix('grupos')->group(function () {

    // Listar todos los grupos
    Route::get('/', [GrupoController::class, 'index'])->name('grupos.index');

    // Formulario para crear un nuevo grupo
    Route::get('/crear', [GrupoController::class, 'create'])->name('grupos.create');

    // Guardar un nuevo grupo
    Route::post('/crear', [GrupoController::class, 'store'])->name('grupos.store');

    // Formulario para editar un grupo
    Route::get('/{grupo}/editar', [GrupoController::class, 'edit'])->name('grupos.edit');

    // Actualizar un grupo
    Route::put('/{grupo}/editar', [GrupoController::class, 'update'])->name('grupos.update');

    // Eliminar un grupo
    Route::delete('/{grupo}', [GrupoController::class, 'destroy'])->name('grupos.destroy');

    // Formulario para importar estudiantes a un grupo
    Route::get('/{grupo}/importar', [GrupoController::class, 'formImportar'])->name('grupos.import.form');

    // Procesar la importación de Excel
    Route::post('/{grupo}/importar', [GrupoController::class, 'importarExcel'])->name('grupos.import.excel');

    // Importar grupos desde Excel (opcional si manejas importación masiva de grupos)
    Route::post('/importar-grupos', [GrupoController::class, 'import'])->name('grupos.import');
});
     
    Route::resource('grupos', GrupoController::class);


    Route::get('grupos/{id}/agregar-estudiantes', [GrupoController::class, 'addStudents'])->name('grupos.addStudents');

    Route::post('grupos/{id}/agregar-estudiantes', [GrupoController::class, 'storeStudents'])->name('grupos.storeStudents');

    // Route::get('grupos/revisar', [App\Http\Controllers\GrupoController::class, 'revisar'])
    // ->name('grupos.revisar')
    // ->middleware('auth');

    // Rutas de asistencias
    Route::get('asistencias', [AsistenciaController::class, 'index'])->name('asistencias.index');
    Route::get('asistencias/create', [AsistenciaController::class, 'create'])->name('asistencias.create');
    Route::post('asistencias', [AsistenciaController::class, 'store'])->name('asistencias.store');
    Route::get('asistencias/{asistencia}/edit', [AsistenciaController::class, 'edit'])->name('asistencias.edit');
    Route::put('asistencias/{asistencia}', [AsistenciaController::class, 'update'])->name('asistencias.update');
    Route::delete('asistencias/{asistencia}', [AsistenciaController::class, 'destroy'])->name('asistencias.destroy');

    Route::get('asistencias/estudiantes/{grupo}', [AsistenciaController::class, 'getEstudiantesByGrupo'])
        ->name('asistencias.getEstudiantesByGrupo');

    Route::get('asistencias/malla/{grupo}', [AsistenciaController::class, 'malla'])->name('asistencias.malla');

    // Rutas para reportes
    Route::get('/asistencias/reporte', [AsistenciaController::class, 'reporte'])
        ->name('asistencias.reporte');
    Route::post('/asistencias/generar-reporte', [AsistenciaController::class, 'generarReporte'])
        ->name('asistencias.generar-reporte');
    Route::get('asistencias/historial/{estudiante}', [AsistenciaController::class, 'historial'])
        ->name('asistencias.historial');

/*
PERIODOS
*/
Route::middleware(['auth','role:admin,coordinador'])->group(function () {
    Route::resource('periodos', PeriodoController::class);
    Route::resource('tutorados', TutoradoController::class);
});


/*
CANALIZACIONES
*/
  
    // Individuales
    Route::resource('individuales', IndividualController::class);
    
    // Canalizaciones
    Route::resource('canalizaciones', CanalizacionController::class);
    Route::get('/canalizaciones/create/{individual?}', [CanalizacionController::class, 'create'])
    ->name('canalizaciones.create');


    // Verifica que tienes las rutas correctamente definidas
    Route::get('canalizaciones/{canalizacione}', [CanalizacionController::class, 'show'])
    ->name('canalizaciones.show');  
    
    // Ruta adicional para verificación AJAX
    Route::post('/individuales/verificar', [IndividualController::class, 'verificar'])
        ->name('individuales.verificar');

     
/*
PATS
*/

    Route::get('/pats', [PatController::class, 'index'])->name('pats.index');
    Route::get('/pats/create', [PatController::class, 'create'])->name('pats.create');
    Route::post('/pats', [PatController::class, 'store'])->name('pats.store');
    Route::get('/pats/{pat}/edit', [PatController::class, 'edit'])->name('pats.edit');
    Route::put('/pats/{pat}', [PatController::class, 'update'])->name('pats.update');
    Route::delete('/pats/{pat}', [PatController::class, 'destroy'])->name('pats.destroy');
    Route::get('/pats/dashboard', [PatController::class, 'dashboard'])->name('pats.dashboard');

/*
ENTREVISTA INDIVIDUAL
*/

Route::middleware(['auth'])->group(function () {

 
    Route::resource('entrevistas', FormularioEntrevistaController::class);

});

/* RUTAS PARA TUTORADO */
Route::middleware(['auth'])->group(function () {

    // Mostrar las entrevistas del tutorado
    Route::get('/mis-entrevistas', 
        [FormularioEntrevistaController::class, 'misEntrevistas']
    )->name('mis-entrevistas');

    // Mostrar el formulario para responder una entrevista
    Route::get('/mis-entrevistas/responder', 
        [FormularioEntrevistaController::class, 'crearComoTutorado']
    )->name('entrevistas.tutorado.create');

    // Guardar la respuesta de la entrevista
    Route::post('/mis-entrevistas/responder', 
        [FormularioEntrevistaController::class, 'guardarComoTutorado']
    )->name('entrevistas.tutorado.store');
});

