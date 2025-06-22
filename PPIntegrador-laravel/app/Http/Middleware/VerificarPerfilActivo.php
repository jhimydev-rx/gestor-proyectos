<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarPerfilActivo
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Si el usuario no tiene perfiles creados
        if ($user->perfiles()->count() === 0) {
            return redirect()->route('perfil.crear')
                ->with('error', 'Debes crear un perfil antes de continuar.');
        }

        // Si no hay un perfil activo en la sesión
        if (!session()->has('perfil_activo')) {
            // Opcional: activar el primero automáticamente
            $primerPerfil = $user->perfiles()->first();

            // Guardar en sesión como perfil activo
            session(['perfil_activo' => $primerPerfil->id]);

            // Redirigir según el tipo
            if ($primerPerfil->tipo === 'creador') {
                return redirect()->route('panel.creador');
            } else {
                return redirect()->route('panel.colaborador');
            }
        }

        return $next($request);
    }
}
