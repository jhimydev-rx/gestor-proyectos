<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\PanelCreadorController;
use App\Http\Controllers\PanelColaboradorController;
use App\Http\Controllers\RedireccionInicioController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\RamaController;
use App\Http\Middleware\VerificarPerfilActivo;
use App\Http\Middleware\SoloCreador;         
use App\Http\Middleware\SoloColaborador;    
use App\Http\Controllers\TareaController;
/*
|--------------------------------------------------------------------------
| Rutas públicas
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Ruta post-login
|--------------------------------------------------------------------------
*/
Route::get('/inicio', RedireccionInicioController::class)
    ->middleware('auth')
    ->name('inicio');

/*
|--------------------------------------------------------------------------
| Rutas protegidas (requieren login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Perfil y configuración de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/perfil/crear', [PerfilController::class, 'create'])->name('perfil.crear');
    Route::post('/perfil', [PerfilController::class, 'store'])->name('perfil.store');
    Route::post('/perfil/cambiar', [PerfilController::class, 'cambiar'])->name('perfil.cambiar');
    Route::get('/perfil/crear/otro', [PerfilController::class, 'crearOtro'])->name('perfil.crear.otro');

    /*
    |--------------------------------------------------------------------------
    | Paneles y funciones protegidas por perfil activo
    |--------------------------------------------------------------------------
    */
    Route::middleware([VerificarPerfilActivo::class])->group(function () {

        // Panel creador
        Route::middleware([SoloCreador::class])->group(function () {
            Route::get('/panel/creador', [PanelCreadorController::class, 'index'])->name('panel.creador');

            // Gestión de proyectos (solo creadores)
            Route::get('/proyectos', [ProyectoController::class, 'index'])->name('proyectos.index');
            Route::get('/proyectos/crear', [ProyectoController::class, 'create'])->name('proyectos.create');
            Route::post('/proyectos', [ProyectoController::class, 'store'])->name('proyectos.store');
            Route::get('/proyectos/{proyecto}/editar', [ProyectoController::class, 'edit'])->name('proyectos.edit');
            Route::put('/proyectos/{proyecto}', [ProyectoController::class, 'update'])->name('proyectos.update');
            Route::delete('/proyectos/{proyecto}', [ProyectoController::class, 'destroy'])->name('proyectos.destroy');

            // Agregar colaboradores
            Route::get('/proyectos/{proyecto}/colaboradores/agregar', [ProyectoController::class, 'agregarColaboradorForm'])->name('proyectos.colaboradores.form');
            Route::post('/proyectos/{proyecto}/colaboradores/agregar', [ProyectoController::class, 'agregarColaborador'])->name('proyectos.colaboradores.agregar');

            // Ramas (solo para creadores)
            Route::get('/proyectos/{proyecto}/ramas/crear', [RamaController::class, 'create'])->name('ramas.create');
            Route::post('/proyectos/{proyecto}/ramas', [RamaController::class, 'store'])->name('ramas.store');
            Route::get('/ramas/{rama}/editar', [RamaController::class, 'edit'])->name('ramas.edit');
            Route::put('/ramas/{rama}', [RamaController::class, 'update'])->name('ramas.update');
            Route::delete('/ramas/{rama}', [RamaController::class, 'destroy'])->name('ramas.destroy');

            //Arbol admin
            Route::get('/proyectos/{proyecto}/ramas/admin', [RamaController::class, 'admin'])->name('proyectos.ramas.admin');


            //Tareas (solo para creadores)
            Route::get('/ramas/{rama}/tareas/crear', [TareaController::class, 'create'])->name('tareas.create');
            Route::post('/ramas/{rama}/tareas', [TareaController::class, 'store'])->name('tareas.store');
            Route::get('/tareas/{tarea}/editar', [TareaController::class, 'edit'])->name('tareas.edit');
            Route::put('/tareas/{tarea}', [TareaController::class, 'update'])->name('tareas.update');

        });
       
        // Panel colaborador
        Route::middleware([SoloColaborador::class])->group(function () {
            Route::get('/panel/colaborador', [PanelColaboradorController::class, 'index'])->name('panel.colaborador');
            Route::get('/colaborador/proyectos', [PanelColaboradorController::class, 'proyectosAsignados'])->name('colaborador.proyectos');
            Route::get('/colaborador/proyectos/{proyecto}', [PanelColaboradorController::class, 'show'])->name('colaborador.proyectos.show');

            //Tareas (Solo colaborador)
            Route::get('/tareas/{tarea}', [TareaController::class, 'show'])->name('tareas.show');

        });

        // Vista general del proyecto (ambos perfiles pueden verla)
        Route::get('/proyectos/{proyecto}', [ProyectoController::class, 'show'])->name('proyectos.show');
    });
});

/*
|--------------------------------------------------------------------------
| Rutas de autenticación generadas por Breeze
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
