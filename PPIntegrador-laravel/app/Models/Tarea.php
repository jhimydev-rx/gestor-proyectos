<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    use HasFactory;

    protected $fillable = [
        'rama_id', 'titulo', 'descripcion', 'fecha_limite',
    ];


    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }

    public function perfil()
    {
        return $this->belongsTo(Perfil::class);
    }

    public function rama()
    {
        return $this->belongsTo(Rama::class);
    }

    public function colaboradores()
    {
        return $this->belongsToMany(Perfil::class, 'colaborador_tarea');
    }

    public function archivos()
    {
        return $this->hasMany(Archivo::class);
    }

    public function mensajes()
    {
        return $this->hasMany(Mensaje::class);
    }
}
