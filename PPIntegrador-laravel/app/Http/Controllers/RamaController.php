<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\Rama;
use App\Models\Perfil;
use Illuminate\Http\Request;

class RamaController extends Controller
{
    // Mostrar formulario para crear rama
    public function create(Proyecto $proyecto)
    {
        // Solo colaboradores disponibles (podrías agregar filtros aquí si deseas)
        $colaboradores = $proyecto->colaboradores;

        return view('ramas.create', compact('proyecto', 'colaboradores'));
    }

    // Guardar la rama en base de datos
    public function store(Request $request, Proyecto $proyecto)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'colaboradores' => 'array|nullable', // Puede ser nulo o array
        ]);

        $rama = Rama::create([
            'proyecto_id' => $proyecto->id,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        // Asignar tareas vacías a los colaboradores seleccionados (o guardarlos en una tabla si quieres)
        

        return redirect()->route('proyectos.show', $proyecto->id)
        ->with('success', 'Rama creada exitosamente.');

    }

    public function show(Rama $rama)
    {
        $tareas = $rama->tareas()->whereHas('colaboradores', function ($q) {
            $q->where('perfil_id', session('perfil_activo'));
        })->get();

        return view('colaborador.rama_show', compact('rama', 'tareas'));
    }

 
    public function admin(Proyecto $proyecto)
    {
        $ramas = $proyecto->ramas()->with('tareas')->get(); // Por si luego quieres mostrar tareas

        return view('ramas.admin', compact('proyecto', 'ramas'));
    }

    public function edit(Rama $rama)
    {
        return view('ramas.edit', compact('rama'));
    }

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

    public function destroy(Rama $rama)
    {
        $proyectoId = $rama->proyecto_id;

        $rama->delete();

        return redirect()->route('proyectos.ramas.admin', $proyectoId)
                        ->with('success', 'Rama eliminada correctamente.');
    }

}
