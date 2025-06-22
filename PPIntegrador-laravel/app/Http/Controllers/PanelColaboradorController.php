<?php

namespace App\Http\Controllers;
use App\Models\Proyecto;
use App\Models\Tarea;
use App\Models\Rama;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class PanelColaboradorController extends Controller
{
    public function index()
    {
        return view('panel.colaborador');
    }

    
    public function proyectosAsignados()
    {
        $perfilId = session('perfil_activo');

        // Obtener IDs de proyectos asignados directamente al colaborador
        $proyectoIds = DB::table('colaborador_proyecto')
                        ->where('perfil_id', $perfilId)
                        ->pluck('proyecto_id');

        // Obtener proyectos
        $proyectos = \App\Models\Proyecto::whereIn('id', $proyectoIds)->get();

        return view('colaborador.proyectos', compact('proyectos'));
    }

    
    public function show(Proyecto $proyecto)
    {
        $perfilId = session('perfil_activo');

        
     
        // 1. Obtener IDs de tareas asignadas a este colaborador
        $tareaIds = DB::table('colaborador_tarea')
                        ->where('perfil_id', $perfilId)
                        ->pluck('tarea_id');

        // 2. Obtener tareas con sus ramas que pertenecen al proyecto actual
        $tareas = Tarea::whereIn('id', $tareaIds)
                        ->whereHas('rama', function ($query) use ($proyecto) {
                            $query->where('proyecto_id', $proyecto->id);
                        })
                        ->get();

        // 3. Agrupar tareas por rama
        $tareasPorRama = $tareas->groupBy('rama_id');

        // 4. Obtener ramas del proyecto que contienen esas tareas
        $ramaIds = $tareas->pluck('rama_id')->unique();
        $ramas = Rama::whereIn('id', $ramaIds)->get();

        return view('colaborador.proyecto_show', compact('proyecto', 'ramas', 'tareasPorRama'));
    }
    



}
