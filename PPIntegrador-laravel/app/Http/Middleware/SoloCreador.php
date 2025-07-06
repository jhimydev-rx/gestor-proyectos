<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SoloCreador
{
    public function handle(Request $request, Closure $next): Response
    {
        $tipoPerfil = session('perfil_activo_tipo');

        if ($tipoPerfil !== 'creador') {
            abort(403, 'Acceso no autorizado. Solo para creadores.');
        }

        return $next($request);
    }
}
