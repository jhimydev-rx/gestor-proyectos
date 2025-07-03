<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mensaje;
use App\Models\Tarea;

class MensajeController extends Controller
{
    public function store(Request $request, Tarea $tarea)
    {
        $request->validate([
            'contenido' => 'required|string|max:1000',
        ]);

        Mensaje::create([
            'tarea_id' => $tarea->id,
            'perfil_id' => session('perfil_activo'),
            'contenido' => $request->contenido,
        ]);

        return back()->with('success', 'Mensaje enviado');
    }

}
