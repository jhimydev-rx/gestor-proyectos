<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RedireccionInicioController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        if (!$user->perfiles()->count()) {
            return redirect()->route('perfil.crear');
        }

        $perfil = $user->perfiles()->find(session('perfil_activo'));

        if (!$perfil) {
            $perfil = $user->perfiles()->first();
            session(['perfil_activo' => $perfil->id]);
        }

        return redirect()->route($perfil->tipo === 'creador' ? 'panel.creador' : 'panel.colaborador');
    }
}
