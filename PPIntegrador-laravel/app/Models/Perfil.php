<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    use HasFactory;

    protected $table = 'perfiles';


    protected $fillable = [
        'user_id', 'tipo', 'nombre_perfil', 'bio', 'foto',
        'ultimo_cambio_nombre', 'activo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function proyectos()
    {
        return $this->belongsToMany(Proyecto::class, 'colaborador_proyecto', 'perfil_id', 'proyecto_id');
    }


    public function archivos()
    {
        return $this->hasMany(Archivo::class);
    }

    // Perfil.php
    public function tareas()
    {
        return $this->hasMany(\App\Models\Tarea::class);
    }



    public function tareasAsignadas()
    {
        return $this->belongsToMany(Tarea::class, 'colaborador_tarea');
    }

    public function mensajes()
    {
        return $this->hasMany(Mensaje::class);
    }

    public function proyectosColaborados()
    {
        return $this->belongsToMany(Proyecto::class, 'colaborador_tarea', 'perfil_id', 'proyecto_id')->distinct();
    }

}
