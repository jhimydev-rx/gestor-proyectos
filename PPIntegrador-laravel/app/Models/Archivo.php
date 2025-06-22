<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    use HasFactory;

    protected $fillable = [
        'tarea_id', 'perfil_id', 'archivo', 'comentario',
    ];

    public function tarea()
    {
        return $this->belongsTo(Tarea::class);
    }

    public function perfil()
    {
        return $this->belongsTo(Perfil::class);
    }
}
