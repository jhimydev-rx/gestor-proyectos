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
        $request->validate([
            'archivo' => 'required|file',
            'comentario' => 'nullable|string|max:1000',
        ]);

        $archivoSubido = $request->file('archivo');
        $nombreArchivo = time() . '_' . $archivoSubido->getClientOriginalName();
        $archivoSubido->storeAs('tareas/' . $tarea->id, $nombreArchivo, 'public');

        Archivo::create([
            'tarea_id'   => $tarea->id,
            'perfil_id'  => session('perfil_activo'),
            'archivo'    => $nombreArchivo,
            'comentario' => $request->comentario,
        ]);

        return back()->with('success', 'Archivo subido correctamente.');
    }
}
