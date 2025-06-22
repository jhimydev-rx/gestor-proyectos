<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;

    protected $fillable = [
        'perfil_id', 'titulo', 'descripcion',
    ];

    public function creador()
    {
        return $this->belongsTo(Perfil::class, 'perfil_id');
    }

    public function ramas()
    {
        return $this->hasMany(Rama::class);
    }

    public function tareas()
    {
        return $this->hasMany(Tarea::class);
    }


    public function colaboradores()
    {
        return $this->belongsToMany(Perfil::class, 'colaborador_proyecto', 'proyecto_id', 'perfil_id')->distinct();
    }


}
