<?php

namespace App\Http\Controllers;

use App\Models\Perfil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerfilController extends Controller
{
    // Mostrar formulario de creación
    public function create()
    {
        return view('perfil.crear');
    }

    // Guardar el perfil nuevo
    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required|in:creador,colaborador',
            'nombre_perfil' => 'required|string|max:50|unique:perfiles,nombre_perfil',
            'bio' => 'nullable|string|max:255',
            'foto' => 'nullable|image|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('perfiles', 'public');
        }

        $perfil = Perfil::create([
            'user_id' => Auth::id(),
            'tipo' => $request->tipo,
            'nombre_perfil' => $request->nombre_perfil,
            'bio' => $request->bio,
            'foto' => $fotoPath,
            'ultimo_cambio_nombre' => now(),
        ]);

        // Guardar perfil activo en sesión
        session(['perfil_activo' => $perfil->id]);

        // Redirigir al panel correspondiente
        return redirect()->route(
            $perfil->tipo === 'creador' ? 'panel.creador' : 'panel.colaborador'
        )->with('success', 'Perfil creado y activado correctamente.');
    }

    // (Opcional) Cambiar perfil activo desde dropdown
    public function cambiar(Request $request)
    {
        $request->validate([
            'perfil_id' => 'required|exists:perfiles,id',
        ]);

        $perfil = auth()->user()->perfiles()->findOrFail($request->perfil_id);

        session(['perfil_activo' => $perfil->id]);

        return redirect()->route($perfil->tipo === 'creador' ? 'panel.creador' : 'panel.colaborador');
    }

    public function crearOtro()
    {
        $user = auth()->user();

        $tipos = $user->perfiles->pluck('tipo')->toArray();

        if (in_array('creador', $tipos) && in_array('colaborador', $tipos)) {
            return redirect()->route('inicio')->with('error', 'Ya tienes ambos perfiles.');
        }

        $tipoFaltante = in_array('creador', $tipos) ? 'colaborador' : 'creador';

        return view('perfil.crear', ['tipoPredefinido' => $tipoFaltante]);
    }


}
