<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    // Formulario para agregar colaborador
    public function agregarColaboradorForm(Proyecto $proyecto)
    {
        $colaboradores = \App\Models\Perfil::where('tipo', 'colaborador')->get();
        return view('proyectos.agregar_colaborador', compact('proyecto', 'colaboradores'));
    }

    // Agregar colaborador al proyecto
    public function agregarColaborador(Request $request, Proyecto $proyecto)
    {
        $request->validate([
            'perfil_id' => 'required|exists:perfiles,id',
        ]);

        $proyecto->colaboradores()->syncWithoutDetaching([$request->perfil_id]);

        return redirect()->back()->with('success', 'Colaborador agregado');
    }

    //Barras de progreso
     public function adminShow(Proyecto $proyecto)
    {
        $proyecto->load('ramas.tareas'); // cargamos ramas y tareas

        $progreso = [];

        foreach ($proyecto->ramas as $rama) {
            $total = $rama->tareas->count();
            $completadas = $rama->tareas->where('estado', 'completada')->count();

            $progreso[$rama->id] = $total > 0 ? round(($completadas / $total) * 100) : 0;
        }

        return view('admin.proyectos.show', compact('proyecto', 'progreso'));
    }

    public function vistaArbol(Proyecto $proyecto)
    {
        $ramas = $proyecto->ramas()->with('tareas')->get();

        $datos = [
            'name' => $proyecto->nombre,
            'children' => $ramas->map(function ($rama) {
                return [
                    'name' => $rama->nombre,
                    'children' => $rama->tareas->map(function ($tarea) {
                        return [
                            'name' => $tarea->titulo,
                            'estado' => $tarea->estado,
                        ];
                    }),
                ];
            }),
        ];

        return view('proyectos.arbol', ['arbolDatos' => $datos]);
    }


}
