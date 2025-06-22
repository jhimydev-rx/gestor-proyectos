<?php

namespace App\Http\Controllers;

use App\Models\Rama;
use App\Models\Tarea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TareaController extends Controller
{

    
    public function create(Rama $rama)
    {
        $proyecto = $rama->proyecto;
        $colaboradores = $proyecto->colaboradores; // asegúrate de tener esta relación o buscar perfiles manualmente

        return view('tareas.create', compact('rama', 'colaboradores'));
    }


    public function store(Request $request, Rama $rama)
{
    $request->validate([
        'titulo' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        'fecha_limite' => 'nullable|date',
        'archivo' => 'nullable|file|max:2048',
    ]);

    $tarea = new Tarea();
    $tarea->titulo = $request->titulo;
    $tarea->descripcion = $request->descripcion;
    $tarea->fecha_limite = $request->fecha_limite;
    $tarea->rama_id = $rama->id;
    $tarea->save();

    // Si hay archivo subido, se guarda como "plantilla"
    //if ($request->hasFile('archivo')) {
      //  $ruta = $request->file('archivo')->store('archivos_tareas', 'public');

        //Archivo::create([
          //  'tarea_id' => $tarea->id,
            //'perfil_id' => session('perfil_activo'),
            //'ruta' => $ruta,
            //'tipo' => 'plantilla',
        //]);
    //}

    return redirect()->route('proyectos.ramas.admin', $rama->proyecto)
                   ->with('success', 'Tarea creada correctamente');
}


    public function edit(Tarea $tarea)
    {
        $rama = $tarea->rama;
        $proyecto = $rama->proyecto;

        // Obtener todos los perfiles colaboradores del proyecto
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

        // Sincronizar colaboradores (puede ser vacío)
        $tarea->colaboradores()->sync($request->colaboradores ?? []);

        return redirect()->route('proyectos.show', $tarea->rama->proyecto_id)
                        ->with('success', 'Tarea actualizada correctamente.');
    }

    public function show(Tarea $tarea)
    {
        // Cargamos relaciones necesarias
        $tarea->load(['rama.proyecto', 'colaboradores', 'archivos']);

        // Verificación de seguridad: ¿el colaborador tiene esta tarea?
        if (!$tarea->colaboradores->contains('id', session('perfil_activo'))) {
            abort(403, 'No tienes acceso a esta tarea.');
        }

        return view('tareas.show', compact('tarea'));
    }




}
