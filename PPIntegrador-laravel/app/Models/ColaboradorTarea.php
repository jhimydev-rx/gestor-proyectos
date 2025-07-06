<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColaboradorTarea extends Model
{
    use HasFactory;

    protected $table = 'colaborador_tarea';

    protected $fillable = [
        'perfil_id', 'tarea_id',
    ];
}
