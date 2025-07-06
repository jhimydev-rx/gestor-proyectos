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

        // 1. Si no tiene perfiles creados, redirigir a crear uno
        if ($user->perfiles()->count() === 0) {
            return redirect()->route('perfil.crear')
                ->with('error', 'Debes crear un perfil antes de continuar.');
        }

        // 2. Si no hay perfil activo en sesión o el perfil no pertenece al usuario actual
        if (!session()->has('perfil_activo') ||
            !$user->perfiles()->where('id', session('perfil_activo'))->exists()) {

            $primerPerfil = $user->perfiles()->first();

            // Guardar ID y tipo del perfil activo en sesión
            session([
                'perfil_activo' => $primerPerfil->id,
                'perfil_activo_tipo' => $primerPerfil->tipo
            ]);

            // Redirigir al panel correspondiente
            //return $this->redirigirPorTipo($primerPerfil->tipo);
        }

        return $next($request);
    }

    protected function redirigirPorTipo(string $tipo)
    {
        return match ($tipo) {
            'creador' => redirect()->route('panel.creador'),
            'colaborador' => redirect()->route('panel.colaborador'),
            default => abort(403, 'Tipo de perfil desconocido.')
        };
    }
}
