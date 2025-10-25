<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminTutoradoController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\TutorDashboardController;
use App\Http\Controllers\TutoradoController;

Route::get('/', fn() => view('welcome'));
Auth::routes();

/*---------------------
| TUTORADO
---------------------*/
Route::middleware(['auth', 'role:tutorado'])->group(function () {
    Route::get('/tutorado/dashboard', [TutoradoController::class, 'dashboard'])->name('tutorado.dashboard');
    Route::post('/tutorado/update', [TutoradoController::class, 'update'])->name('tutorado.update');
});

/*---------------------
| ADMIN
---------------------*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');

    Route::get('/register', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'store'])->name('register.store');

    Route::resource('users', AdminUserController::class);
    Route::resource('tutorados', AdminTutoradoController::class);

    Route::get('/configuracion', [ConfiguracionController::class, 'index'])->name('configuracion.index');
    Route::get('/configuracion/create', [ConfiguracionController::class, 'create'])->name('configuracion.create');
    Route::post('/configuracion', [ConfiguracionController::class, 'store'])->name('configuracion.store');
});

/*---------------------
| DOCENTE
---------------------*/
Route::middleware(['auth', 'role:docente'])->group(function () {
    Route::get('/docente/dashboard', fn() => view('docente.dashboard'))->name('docente.dashboard');
    Route::get('/tutores', [TutorController::class, 'index'])->name('tutores.index');
    Route::get('/dashboard/tutor', [TutorDashboardController::class, 'index'])->name('dashboard.tutor');
});

/*---------------------
| COORDINADOR
---------------------*/
Route::middleware(['auth', 'role:coordinador'])->prefix('coordinador')->name('coordinador.')->group(function () {
    Route::get('/dashboard', fn() => view('coordinador.dashboard'))->name('dashboard');

    // ✅ Coordinador puede listar y editar tutorados, pero no crear ni eliminar
    Route::get('/tutorados', [AdminTutoradoController::class, 'index'])->name('tutorados.index');
    Route::get('/tutorados/{id}/edit', [AdminTutoradoController::class, 'edit'])->name('tutorados.edit');
    Route::put('/tutorados/{id}', [AdminTutoradoController::class, 'update'])->name('tutorados.update');
});
