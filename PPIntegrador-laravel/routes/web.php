<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\PanelCreadorController;
use App\Http\Controllers\PanelColaboradorController;
use App\Http\Controllers\RedireccionInicioController;
use App\Http\Middleware\VerificarPerfilActivo;
use App\Http\Controllers\ProyectoController;

/*
|--------------------------------------------------------------------------
| Rutas públicas
|--------------------------------------------------------------------------
*/

// Página de bienvenida pública del proyecto
Route::get('/', function () {
    return view('welcome');
});


/*
|--------------------------------------------------------------------------
| Ruta de entrada post-login (redirige según perfil activo)
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

    // Configuración del usuario (nombre, correo, contraseña, etc.)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Crear perfil de creador o colaborador
    Route::get('/perfil/crear', [PerfilController::class, 'create'])->name('perfil.crear');
    Route::post('/perfil', [PerfilController::class, 'store'])->name('perfil.store');

    // Cambio de perfil
    Route::post('/perfil/cambiar', [PerfilController::class, 'cambiar'])->name('perfil.cambiar');

    // Crear automáticamente el segundo tipo de perfil (el que falta)
    Route::get('/perfil/crear/otro', [PerfilController::class, 'crearOtro'])->name('perfil.crear.otro');




    // Paneles de usuario protegidos por tener un perfil activo
    Route::middleware([VerificarPerfilActivo::class])->group(function () {

        // Panel para perfil de creador
        Route::get('/panel/creador', [PanelCreadorController::class, 'index'])
            ->name('panel.creador');

        // Panel para perfil de colaborador
        Route::get('/panel/colaborador', [PanelColaboradorController::class, 'index'])
            ->name('panel.colaborador');
        
        //Vista de proyectos para colaborador
        Route::get('/colaborador/proyectos', [PanelColaboradorController::class, 'proyectosAsignados'])
            ->name('colaborador.proyectos');

        //Show para colaboradores
        Route::get('/colaborador/proyectos/{proyecto}', [PanelColaboradorController::class, 'show'])
            ->name('colaborador.proyectos.show');

        // Vista para agregar colaboradores a un proyecto
        Route::get('/proyectos/{proyecto}/colaboradores/agregar', [ProyectoController::class, 'agregarColaboradorForm'])
            ->name('proyectos.colaboradores.form');

        //  POST para agregar colaborador
        Route::post('/proyectos/{proyecto}/colaboradores/agregar', [ProyectoController::class, 'agregarColaborador'])
            ->name('proyectos.colaboradores.agregar');
    });

    // 👉 Gestión de proyectos
    Route::get('/proyectos', [ProyectoController::class, 'index'])->name('proyectos.index');
    Route::get('/proyectos/crear', [ProyectoController::class, 'create'])->name('proyectos.create');
    Route::post('/proyectos', [ProyectoController::class, 'store'])->name('proyectos.store');
    Route::get('/proyectos/{proyecto}', [ProyectoController::class, 'show'])->name('proyectos.show');
    Route::get('/proyectos/{proyecto}/editar', [ProyectoController::class, 'edit'])->name('proyectos.edit');
    Route::put('/proyectos/{proyecto}', [ProyectoController::class, 'update'])->name('proyectos.update');
    Route::delete('/proyectos/{proyecto}', [ProyectoController::class, 'destroy'])->name('proyectos.destroy');

});


/*
|--------------------------------------------------------------------------
| Rutas de autenticación generadas por Breeze
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';
