<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\Tarea;
use App\Models\Rama;
use Illuminate\Http\Request;

class ProyectoController extends Controller
{
    // Mostrar lista de proyectos del perfil creador
    public function index()
    {
        $perfilId = session('perfil_activo');

        $proyectos = Proyecto::where('perfil_id', $perfilId)->get();

        return view('proyectos.index', compact('proyectos'));
    }

    // Mostrar formulario para crear un nuevo proyecto
    public function create()
    {
        return view('proyectos.create');
    }

    // Guardar un nuevo proyecto
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        Proyecto::create([
            'perfil_id' => session('perfil_activo'),
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('proyectos.index')->with('success', 'Proyecto creado correctamente');
    }

    // Mostrar detalle de un proyecto
    public function show(Proyecto $proyecto)
    {
        // Obtener colaboradores asociados directamente al proyecto
        $colaboradores = $proyecto->colaboradores()->get();

        return view('proyectos.show', compact('proyecto', 'colaboradores'));
    }




    // Mostrar formulario para editar un proyecto
    public function edit(Proyecto $proyecto)
    {
        return view('proyectos.edit', compact('proyecto'));
    }

    // Actualizar el proyecto
    public function update(Request $request, Proyecto $proyecto)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $proyecto->update($request->only('titulo', 'descripcion'));

        return redirect()->route('proyectos.index')->with('success', 'Proyecto actualizado');
    }

    // Eliminar el proyecto
    public function destroy(Proyecto $proyecto)
    {
        $proyecto->delete();

        return redirect()->route('proyectos.index')->with('success', 'Proyecto eliminado');
    }

        // ProyectoController.php
    public function agregarColaboradorForm(Proyecto $proyecto)
    {
        // Solo perfiles tipo 'colaborador'
        $colaboradores = \App\Models\Perfil::where('tipo', 'colaborador')->get();

        return view('proyectos.agregar_colaborador', compact('proyecto', 'colaboradores'));
    }

    public function agregarColaborador(Request $request, Proyecto $proyecto)
    {
        $request->validate([
            'perfil_id' => 'required|exists:perfiles,id',
        ]);

        // Adjuntar sin duplicar
        $proyecto->colaboradores()->syncWithoutDetaching([$request->perfil_id]);

        return redirect()->back()->with('success', 'Colaborador agregado');
    }


}
