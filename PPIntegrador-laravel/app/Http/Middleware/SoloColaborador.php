<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SoloColaborador
{
    public function handle(Request $request, Closure $next): Response
    {
        $tipoPerfil = session('perfil_activo_tipo');

        if ($tipoPerfil !== 'colaborador') {
            abort(403, 'Acceso no autorizado. Solo para colaboradores.');
        }

        return $next($request);
    }
}
