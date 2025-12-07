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

    // perfil docente
    Route::get('mi-perfil', [TutorController::class, 'perfil'])
        ->name('tutores.perfil');

    Route::put('mi-perfil', [TutorController::class, 'actualizarPerfil'])
        ->name('tutores.actualizarPerfil');
});

/*
DIAGNÓSTICOS
*/
Route::middleware('auth')->group(function () {

    Route::resource('diagnosticos', DiagnosticoController::class);

    Route::post('diagnosticos/{diagnostico}/responder', [DiagnosticoController::class, 'responder'])
        ->name('diagnosticos.responder');
});

/*
GRUPOS y ASISTENCIAS
*/
Route::middleware(['auth'])->group(function () {

    Route::resource('asistencias', AsistenciaController::class);

    Route::resource('grupos', GrupoController::class);

    Route::get('grupos/{id}/agregar-estudiantes', [GrupoController::class, 'addStudents'])
        ->name('grupos.addStudents');

    Route::post('grupos/{id}/agregar-estudiantes', [GrupoController::class, 'storeStudents'])
        ->name('grupos.storeStudents');

    Route::get('grupos/{grupo}/estudiantes', [AsistenciaController::class, 'estudiantesPorGrupo']);
});

/*
CANALIZACIONES
*/
Route::middleware('auth')->group(function () {

    Route::resource('canalizaciones', CanalizacionController::class);
});
