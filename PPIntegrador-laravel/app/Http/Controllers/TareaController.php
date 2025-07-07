<?php

namespace App\Http\Controllers;

use App\Models\Rama;
use App\Models\Tarea;
use App\Models\Archivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TareaController extends Controller
{
    public function create(Rama $rama)
    {
        $proyecto = $rama->proyecto;
        $colaboradores = $proyecto->colaboradores;

        return view('tareas.create', compact('rama', 'colaboradores'));
    }

    public function store(Request $request, Rama $rama)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_limite' => 'nullable|date',
            'archivo' => 'nullable|file|mimes:pdf,doc,docx,xlsx,ppt,pptx,txt,jpg,png',
            'comentario' => 'nullable|string|max:1000',
        ]);

        // Crear la tarea
        $tarea = new Tarea();
        $tarea->titulo = $request->titulo;
        $tarea->descripcion = $request->descripcion;
        $tarea->fecha_limite = $request->fecha_limite;
        $tarea->rama_id = $rama->id;
        $tarea->save();

        // Procesar archivo si se subió
        if ($request->hasFile('archivo')) {
            $perfilId = session('perfil_activo');

            if ($perfilId) {
                $ruta = $request->file('archivo')->store('tareas', 'public');

                Archivo::create([
                    'tarea_id' => $tarea->id,
                    'perfil_id' => $perfilId,
                    'archivo' => $ruta,
                    'comentario' => $request->comentario,
                    'tipo' => 'plantilla',
                ]);
            }
        }

        return redirect()->route('proyectos.ramas.admin', $rama->proyecto)
                         ->with('success', 'Tarea y archivo plantilla guardados correctamente.');
    }

    public function edit(Tarea $tarea)
    {
        $rama = $tarea->rama;
        $proyecto = $rama->proyecto;
        $colaboradores = $proyecto->colaboradores;

        return view('tareas.edit', compact('tarea', 'colaboradores'));
    }

    public function update(Request $request, Tarea $tarea)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_limite' => 'nullable|date',
            'colaboradores' => 'array',
            'colaboradores.*' => 'exists:perfiles,id',
        ]);

        $tarea->update([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'fecha_limite' => $request->fecha_limite,
        ]);

        $tarea->colaboradores()->sync($request->colaboradores ?? []);

        $tarea->refresh(); 

        return redirect()->route('proyectos.show', $tarea->rama->proyecto_id)
                         ->with('success', 'Tarea actualizada correctamente.');
    }

    public function show(Tarea $tarea)
    {
        $tarea->load(['rama.proyecto', 'colaboradores', 'archivos']);

        $perfilActivo = session('perfil_activo');
        $esColaborador = $tarea->colaboradores->contains('id', $perfilActivo);
        $esCreador = $perfilActivo === $tarea->rama->proyecto->perfil_id;

        if (!$esColaborador && !$esCreador) {
            abort(403, 'No tienes acceso a esta tarea.');
        }

        // Redirección personalizada
        if ($esColaborador) {
            $urlRetorno = route('colaborador.proyectos.show', $tarea->rama->proyecto->id);
        } else {
            $urlRetorno = route('proyectos.show', $tarea->rama->proyecto->id);
        }

        return view('tareas.show', compact('tarea', 'urlRetorno'));
    }

    public function adminShow(Tarea $tarea)
    {
        $tarea->load(['rama.proyecto', 'colaboradores']);

        $colaboradores = $tarea->rama->proyecto->colaboradores;

        return view('tareas.admin-show', [
            'tarea' => $tarea,
            'colaboradores' => $colaboradores
        ]);
    }

    public function destroy(Tarea $tarea)
    {
        foreach ($tarea->archivos as $archivo) {
            \Storage::disk('public')->delete($archivo->archivo);
            $archivo->delete();
        }

        $tarea->delete();

        return redirect()->route('proyectos.ramas.admin', $tarea->rama->proyecto)
                         ->with('success', 'Tarea eliminada correctamente.');
    }

    public function cambiarEstado(Tarea $tarea)
    {
        $perfilId = session('perfil_activo');

        if ($tarea->estado === 'pendiente') {
            $tarea->estado = 'en_proceso';
                $tarea->refresh(); 
        } elseif ($tarea->estado === 'en_proceso') {
            $tarea->estado = 'completada';
                    $tarea->refresh(); 
        }

        $tarea->save();
    
        return redirect()->back()->with('success', 'Estado de la tarea actualizado.');
    }

    public function cambiarEstadoAdmin(Tarea $tarea)
    {
        $nuevoEstado = request('estado');

        if (in_array($nuevoEstado, ['pendiente', 'en_proceso', 'completada'])) {
            $tarea->estado = $nuevoEstado;
            $tarea->save();
            $tarea->refresh(); 
            return redirect()->back()->with('success', 'Estado actualizado por el admin.');
        }
       
        return redirect()->back()->with('error', 'Estado no válido.');
    }
}