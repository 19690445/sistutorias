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
use App\Http\Controllers\EstudianteController;

/*
RUTA PRINCIPAL
*/
Route::get('/', fn() => view('welcome'));
Auth::routes();

/*
TUTORADO
*/
Route::middleware(['auth', 'role:tutorado'])->group(function () {

    // Dashboard 
    Route::get('/tutorado/dashboard', [TutoradoDashboardController::class, 'index'])
        ->name('tutorado.dashboard');

    Route::post('/tutorado/update', [TutoradoController::class, 'update'])
        ->name('tutorado.update');
});

/*
| ADMIN
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')->name('admin.')
    ->group(function () {

        Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');

        // Registro
        Route::get('/register', [App\Http\Controllers\Auth\RegisteredUserController::class, 'create'])
            ->name('register');
        Route::post('/register', [App\Http\Controllers\Auth\RegisteredUserController::class, 'store'])
            ->name('register.store');

        // Recursos
        Route::resource('users', AdminUserController::class);
        Route::resource('tutorados', AdminTutoradoController::class);

        // Admin y coordinador informacion docente
        Route::middleware(['role:admin,coordinador'])->group(function () {
        Route::resource('tutores', TutorController::class);
        });

        // Configuración
        Route::get('/configuracion', [ConfiguracionController::class, 'index'])->name('configuracion.index');
        Route::get('/configuracion/create', [ConfiguracionController::class, 'create'])->name('configuracion.create');
        Route::post('/configuracion', [ConfiguracionController::class, 'store'])->name('configuracion.store');

        // PERIODOS ADMIN y COORDINADOR
        
        // Index
        Route::get('periodos', [PeriodoController::class, 'index'])->name('periodos.index');

        // Create
        Route::get('periodos/create', [PeriodoController::class, 'create'])->name('periodos.create');

        // Store
        Route::post('periodos', [PeriodoController::class, 'store'])->name('periodos.store');
    });

/*
| DOCENTE
*/
Route::middleware(['auth', 'role:docente'])->group(function () {

    // Route::get('mi-perfil', [TutorController::class, 'perfil'])->name('tutores.perfil');
    // Route::put('mi-perfil', [TutorController::class, 'actualizarPerfil'])->name('tutores.actualizarPerfil');

    Route::get('/docente/dashboard', fn() => view('docente.dashboard'))
        ->name('docente.dashboard');

    Route::get('/tutores', [TutorController::class, 'index'])
        ->name('tutores.index');

    Route::get('/dashboard/tutor', [TutorDashboardController::class, 'index'])
        ->name('dashboard.tutor');

});

/*
| COORDINADOR
*/
    Route::middleware(['auth', 'role:admin,coordinador'])
        ->prefix('coordinador')->name('coordinador.')
        ->group(function () {


        Route::get('/dashboard', fn() => view('coordinador.dashboard'))
            ->name('dashboard');

        // // Admin y coordinador informacion docente
        // Route::middleware(['role:admin,coordinador'])->group(function () {
        // Route::resource('tutores', TutorController::class);
        // });

        // gestiona tutorados
        Route::get('/tutorados', [AdminTutoradoController::class, 'index'])->name('tutorados.index');
        Route::get('/tutorados/{id}/edit', [AdminTutoradoController::class, 'edit'])->name('tutorados.edit');
        Route::put('/tutorados/{id}', [AdminTutoradoController::class, 'update'])->name('tutorados.update');

            // PERIODOS ADMIN y COORDINADOR
    // Index
    Route::get('periodos', [PeriodoController::class, 'index'])->name('periodos.index');

    // Create
    Route::get('periodos/create', [PeriodoController::class, 'create'])->name('periodos.create');

    // Store
    Route::post('periodos', [PeriodoController::class, 'store'])->name('periodos.store');
});

    

/*
| DIAGNÓSTICOS
*/
    Route::middleware('auth')->group(function () {

    Route::resource('diagnosticos', DiagnosticoController::class);

    Route::post('diagnosticos/{diagnostico}/responder', [DiagnosticoController::class, 'responder'])
            ->name('diagnosticos.responder');
    });

/*
| GRUPOS y ASISTENCIAS
*/
    Route::middleware(['auth'])->group(function() {
    Route::resource('asistencias', AsistenciaController::class);

    Route::resource('grupos', GrupoController::class);
    Route::get('grupos/{id}/agregar-estudiantes', [GrupoController::class, 'addStudents'])->name('grupos.addStudents');
    Route::post('grupos/{id}/agregar-estudiantes', [GrupoController::class, 'storeStudents'])->name('grupos.storeStudents');

    // RUTA AJAX
    Route::get('grupos/{grupo}/estudiantes', [AsistenciaController::class, 'estudiantesPorGrupo']);
});

/*
CANALIZACIONES
*/
Route::middleware('auth')->group(function () {
    Route::get('canalizaciones', [CanalizacionController::class, 'index'])->name('canalizaciones.index');
    Route::get('canalizaciones/create', [CanalizacionController::class, 'create'])->name('canalizaciones.create');
    Route::post('canalizaciones', [CanalizacionController::class, 'store'])->name('canalizaciones.store');
    Route::get('canalizaciones/{id}', [CanalizacionController::class, 'show'])->name('canalizaciones.show');
    Route::get('canalizaciones/{id}/edit', [CanalizacionController::class, 'edit'])->name('canalizaciones.edit');
    Route::put('canalizaciones/{id}', [CanalizacionController::class, 'update'])->name('canalizaciones.update');
    Route::delete('canalizaciones/{id}', [CanalizacionController::class, 'destroy'])->name('canalizaciones.destroy');
});


Route::middleware(['auth', 'role:admin,coordinador,docente'])->group(function () {
    Route::resource('tutores', TutorController::class);
    
    // Ruta única para crear tutores
    Route::get('tutores/create', [TutorController::class, 'create'])
        ->name('tutores.create');

    Route::post('tutores', [TutorController::class, 'store'])
        ->name('tutores.store');

    // Editar tutor
    Route::get('tutores/{tutor}/edit', [TutorController::class, 'edit'])
        ->name('tutores.edit');

    Route::put('tutores/{tutor}', [TutorController::class, 'update'])
        ->name('tutores.update');

    // Lista de tutores
    Route::get('tutores', [TutorController::class, 'index'])
        ->name('tutores.index');

    // Ver perfil propio (solo tutor)
    Route::get('mi-perfil', [TutorController::class, 'perfil'])
        ->name('tutores.perfil');

    Route::put('mi-perfil', [TutorController::class, 'actualizarPerfil'])
        ->name('tutores.actualizarPerfil');
});

/*
PERFIL ESTUDIANTES
*/
    Route::middleware(['auth'])->group(function () {

        // Admin y Coordinador
        Route::middleware(['role:admin,coordinador'])->group(function () {
            Route::resource('estudiantes', EstudianteController::class);
        });

        // Docente
        Route::middleware(['role:docente'])->group(function () {
            Route::get('/estudiantes/docente', [EstudianteController::class, 'indexDocente'])
                ->name('estudiantes.docente.index');
        });

        // Estudiante 
        Route::middleware(['role:estudiante'])->group(function () {
            Route::get('/mi-perfil', [EstudianteController::class, 'perfil'])
                ->name('estudiantes.perfil');
            Route::put('/mi-perfil/{id}', [EstudianteController::class, 'updatePerfil'])
                ->name('estudiantes.perfil.update');
        });
});

