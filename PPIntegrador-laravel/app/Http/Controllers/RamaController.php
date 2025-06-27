<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\Rama;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RamaController extends Controller
{
    // Mostrar formulario para crear rama
    public function create(Proyecto $proyecto)
    {
        $colaboradores = $proyecto->colaboradores;
        return view('ramas.create', compact('proyecto', 'colaboradores'));
    }



    // Guardar rama
    public function store(Request $request, Proyecto $proyecto)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'colaboradores' => 'array|nullable',
        ]);

        $rama = Rama::create([
            'proyecto_id' => $proyecto->id,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('proyectos.show', $proyecto->id)
            ->with('success', 'Rama creada exitosamente.');
    }

    // Mostrar rama para colaborador
    public function show(Rama $rama)
    {
        $tareas = $rama->tareas()->whereHas('colaboradores', function ($q) {
            $q->where('perfil_id', session('perfil_activo'));
        })->get();

        return view('colaborador.rama_show', compact('rama', 'tareas'));
    }

    // Vista administrativa de ramas
    public function admin(Proyecto $proyecto)
    {
        $ramas = $proyecto->ramas()->with('tareas')->get();
        return view('ramas.admin', compact('proyecto', 'ramas'));
    }

    // Editar rama
    public function edit(Rama $rama)
    {
        $proyecto = $rama->proyecto;
        return view('ramas.edit', compact('rama', 'proyecto'));
    }

    // Actualizar rama
    public function update(Request $request, Rama $rama)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $rama->update($request->only('nombre', 'descripcion'));

        return redirect()->route('proyectos.ramas.admin', $rama->proyecto_id)
            ->with('success', 'Rama actualizada correctamente.');
    }

    // Eliminar rama
    public function destroy(Rama $rama)
    {
        $proyectoId = $rama->proyecto_id;
        $rama->delete();

        return redirect()->route('proyectos.ramas.admin', $proyectoId)
            ->with('success', 'Rama eliminada correctamente.');
    }

    // 📎 Subir archivo a rama
    public function subirArchivo(Request $request, $proyectoId, $ramaId)
    {
        $request->validate([
            'archivo' => 'required|file|max:10240', // máx 10MB
        ]);

        $perfilId = session('perfil_activo');
        $proyecto = Proyecto::findOrFail($proyectoId);

        $esCreador = $proyecto->perfil_id == $perfilId;
        $esColaborador = $proyecto->colaboradores->contains('id', $perfilId);

        if (!($esCreador || $esColaborador)) {
            abort(403, 'No autorizado');
        }

        $archivo = $request->file('archivo');
        $nombre = time() . '_' . $archivo->getClientOriginalName();
        $ruta = "ramas/{$ramaId}";

        $archivo->storeAs($ruta, $nombre, 'public');

        return back()->with('archivo_subido', 'Archivo subido correctamente.');
    }

    // 📥 Descargar archivo de rama
    public function descargarArchivo(Rama $rama, $archivo)
    {
        $perfilId = session('perfil_activo');
        $proyecto = $rama->proyecto;

        $esCreador = $proyecto->perfil_id == $perfilId;
        $esColaborador = $proyecto->colaboradores->contains('id', $perfilId);

        if (!($esCreador || $esColaborador)) {
            abort(403, 'No autorizado');
        }

        $ruta = "ramas/{$rama->id}/{$archivo}";

        if (!Storage::disk('public')->exists($ruta)) {
            abort(404, 'Archivo no encontrado');
        }

        return Storage::disk('public')->download($ruta);
    }

    // 🗑️ Eliminar archivo de rama
    public function eliminarArchivo(Rama $rama, $archivo)
    {
        $perfilId = session('perfil_activo');
        $proyecto = $rama->proyecto;

        $esCreador = $proyecto->perfil_id == $perfilId;
        $esColaborador = $proyecto->colaboradores->contains('id', $perfilId);

        if (!($esCreador || $esColaborador)) {
            abort(403, 'No autorizado');
        }

        $ruta = "ramas/{$rama->id}/{$archivo}";

        if (Storage::disk('public')->exists($ruta)) {
            Storage::disk('public')->delete($ruta);
            return back()->with('success', 'Archivo eliminado correctamente.');
        }

        return back()->with('error', 'Archivo no encontrado.');
    }

    
   
}
