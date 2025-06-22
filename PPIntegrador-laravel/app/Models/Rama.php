<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rama extends Model
{
    use HasFactory;

    protected $fillable = [
        'proyecto_id', 'nombre', 'descripcion',
    ];

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }

    public function tareas()
    {
        return $this->hasMany(Tarea::class);
    }
}
