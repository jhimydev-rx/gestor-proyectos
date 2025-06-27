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
use App\Http\Controllers\ArchivoController;
use App\Http\Controllers\SocialLoginController; // ⬅️ Asegúrate de agregar esto

Route::get('/', function () {
    return view('welcome');
});

Route::get('/inicio', RedireccionInicioController::class)
    ->middleware('auth')
    ->name('inicio');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/perfil/crear', [PerfilController::class, 'create'])->name('perfil.crear');
    Route::post('/perfil', [PerfilController::class, 'store'])->name('perfil.store');
    Route::post('/perfil/cambiar', [PerfilController::class, 'cambiar'])->name('perfil.cambiar');
    Route::get('/perfil/crear/otro', [PerfilController::class, 'crearOtro'])->name('perfil.crear.otro');

    Route::middleware([VerificarPerfilActivo::class])->group(function () {
        Route::middleware([SoloCreador::class])->group(function () {
            Route::get('/panel/creador', [PanelCreadorController::class, 'index'])->name('panel.creador');

            Route::get('/proyectos', [ProyectoController::class, 'index'])->name('proyectos.index');
            Route::get('/proyectos/crear', [ProyectoController::class, 'create'])->name('proyectos.create');
            Route::post('/proyectos', [ProyectoController::class, 'store'])->name('proyectos.store');
            Route::get('/proyectos/{proyecto}/editar', [ProyectoController::class, 'edit'])->name('proyectos.edit');
            Route::put('/proyectos/{proyecto}', [ProyectoController::class, 'update'])->name('proyectos.update');
            Route::delete('/proyectos/{proyecto}', [ProyectoController::class, 'destroy'])->name('proyectos.destroy');

            Route::get('/proyectos/{proyecto}/colaboradores/agregar', [ProyectoController::class, 'agregarColaboradorForm'])->name('proyectos.colaboradores.form');
            Route::post('/proyectos/{proyecto}/colaboradores/agregar', [ProyectoController::class, 'agregarColaborador'])->name('proyectos.colaboradores.agregar');

            Route::get('/proyectos/{proyecto}/ramas/crear', [RamaController::class, 'create'])->name('ramas.create');
            Route::post('/proyectos/{proyecto}/ramas', [RamaController::class, 'store'])->name('ramas.store');
            Route::get('/ramas/{rama}/editar', [RamaController::class, 'edit'])->name('ramas.edit');
            Route::put('/ramas/{rama}', [RamaController::class, 'update'])->name('ramas.update');
            Route::delete('/ramas/{rama}', [RamaController::class, 'destroy'])->name('ramas.destroy');

            Route::post('/proyectos/{proyecto}/ramas/{rama}/archivos', [RamaController::class, 'subirArchivo'])->name('ramas.archivos.subir');
            Route::get('/ramas/{rama}/archivos/{archivo}', [RamaController::class, 'descargarArchivo'])->name('ramas.archivos.descargar');
            Route::delete('/ramas/{rama}/archivos/{archivo}', [RamaController::class, 'eliminarArchivo'])->name('ramas.archivos.eliminar');

            Route::get('/proyectos/{proyecto}/ramas/admin', [RamaController::class, 'admin'])->name('proyectos.ramas.admin');
            //Barra de progreso
            Route::get('/proyectos/{proyecto}', [ProyectoController::class, 'adminShow'])->name('proyectos.admin.show');


            Route::get('/ramas/{rama}/tareas/crear', [TareaController::class, 'create'])->name('tareas.create');
            Route::post('/ramas/{rama}/tareas', [TareaController::class, 'store'])->name('tareas.store');
            Route::get('/tareas/{tarea}/editar', [TareaController::class, 'edit'])->name('tareas.edit');
            Route::put('/tareas/{tarea}', [TareaController::class, 'update'])->name('tareas.update');
            Route::delete('/tareas/{tarea}', [TareaController::class, 'destroy'])->name('tareas.destroy');
            Route::patch('/admin/tareas/{tarea}/cambiar-estado', [TareaController::class, 'cambiarEstadoAdmin'])->name('admin.tareas.cambiarEstado');
            Route::delete('/tareas/{tarea}/archivos/{archivo}', [ArchivoController::class, 'destroy'])->name('tareas.archivos.destroy');
            Route::get('/admin/tareas/{tarea}', [TareaController::class, 'adminShow'])->name('admin.tareas.show');

            //Arbol
            Route::get('/proyectos/{proyecto}/arbol', [ProyectoController::class, 'vistaArbol'])->name('proyectos.arbol');


        });

        Route::middleware([SoloColaborador::class])->group(function () {
            Route::get('/panel/colaborador', [PanelColaboradorController::class, 'index'])->name('panel.colaborador');
            Route::get('/colaborador/proyectos', [PanelColaboradorController::class, 'proyectosAsignados'])->name('colaborador.proyectos');
            Route::get('/colaborador/proyectos/{proyecto}', [PanelColaboradorController::class, 'show'])->name('colaborador.proyectos.show');

            Route::get('/tareas/{tarea}', [TareaController::class, 'show'])->name('tareas.show');
            Route::post('/tareas/{tarea}/archivos', [ArchivoController::class, 'store'])->name('tareas.archivos.store');
            Route::patch('/tareas/{tarea}/cambiar-estado', [TareaController::class, 'cambiarEstado'])->name('tareas.cambiarEstado');

        });

        Route::get('/proyectos/{proyecto}', [ProyectoController::class, 'show'])->name('proyectos.show');
    });
});

require __DIR__.'/auth.php';

Route::get('auth/github', [SocialLoginController::class, 'redirectToGithub'])->name('auth.github');
Route::get('auth/github/callback', [SocialLoginController::class, 'handleGithubCallback']);

Route::get('auth/google', [SocialLoginController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [SocialLoginController::class, 'handleGoogleCallback']);