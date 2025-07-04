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
        // Suponiendo que estás usando autenticación
        $usuario = auth()->user();

        // Verificamos cuántos perfiles tiene el usuario
        $cantidadPerfiles = $usuario->perfiles()->count();

        // Si ya tiene 2 perfiles, lo redirigimos con un mensaje de error
        if ($cantidadPerfiles >= 2) {
            return redirect()->route('inicio')->with('error', 'No puedes crear más de 2 perfiles.');
        }

        // Si no tiene 2 perfiles, se muestra la vista de creación
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
        session([
            'perfil_activo' => $perfil->id,
            'perfil_activo_tipo' => $perfil->tipo
        ]);
        session()->save(); // Asegura que la sesión se guarde antes de redirigir

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

        session([
            'perfil_activo' => $perfil->id,
            'perfil_activo_tipo' => $perfil->tipo, // << IMPORTANTE
        ]);

        return redirect()->route($perfil->tipo === 'creador' ? 'panel.creador' : 'panel.colaborador');
    }


    public function crearOtro()
    {
        $user = auth()->user();

        // Obtener solo los perfiles activos
        $tiposActivos = $user->perfiles->where('activo', true)->pluck('tipo')->toArray();

        // Si ya tiene creador y colaborador activos, no puede crear otro
        if (in_array('creador', $tiposActivos) && in_array('colaborador', $tiposActivos)) {
            return redirect()->route('inicio')->with('error', 'Ya tienes ambos perfiles activos.');
        }

        // Detectar qué tipo le falta (de los activos)
        $tipoFaltante = in_array('creador', $tiposActivos) ? 'colaborador' : 'creador';

        return view('perfil.crear', ['tipoPredefinido' => $tipoFaltante]);
    }


    public function eliminar($id)
    {
        $perfil = Perfil::findOrFail($id);

        if (!$perfil->activo) {
            return back()->with('status', 'El perfil ya estaba desactivado.');
        }

        $perfil->activo = 0;
        $perfil->save();

        return back()->with('status', 'Perfil eliminado correctamente.');
    }


}