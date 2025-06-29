<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Archivo;
use App\Models\Tarea;

class ArchivoController extends Controller
{
    /**
     * Subir archivo asociado a una tarea.
     */
    public function store(Request $request, Tarea $tarea)
    {
        $perfilId = session('perfil_activo');
        $perfilCreadorId = $tarea->rama->proyecto->perfil_id;
        $colaboradoresIds = $tarea->colaboradores->pluck('id');

        $esCreador = $perfilId == $perfilCreadorId;
        $esColaborador = $colaboradoresIds->contains($perfilId);

        if (!($esCreador || $esColaborador)) {
            abort(403, 'No tienes permiso para subir archivos a esta tarea.');
        }

        $request->validate([
            'archivo' => 'required|file',
            'comentario' => 'nullable|string|max:1000',
        ]);

        $archivoSubido = $request->file('archivo');
        $nombreArchivo = time() . '_' . $archivoSubido->getClientOriginalName();
        $archivoSubido->storeAs('tareas/' . $tarea->id, $nombreArchivo, 'public');

        // Determinar tipo automáticamente
        $tipo = $esCreador ? 'plantilla' : 'revision';

        Archivo::create([
            'tarea_id'   => $tarea->id,
            'perfil_id'  => $perfilId,
            'archivo'    => $nombreArchivo,
            'comentario' => $request->comentario,
            'tipo'       => $tipo,
        ]);

        return back()->with('success', 'Archivo subido correctamente como ' . $tipo . '.');
    }


    /**
     * Eliminar archivo de una tarea
     */
    public function destroy(Tarea $tarea, Archivo $archivo)
    {
        if ($archivo->tarea_id !== $tarea->id) {
            abort(403, 'Archivo no pertenece a la tarea');
        }

        $ruta = 'tareas/' . $tarea->id . '/' . $archivo->archivo;

        if (Storage::disk('public')->exists($ruta)) {
            Storage::disk('public')->delete($ruta);
        }

        $archivo->delete();

        return redirect()->back()->with('success', 'Archivo eliminado correctamente.');
    }
}
