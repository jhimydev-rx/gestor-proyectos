<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('colaborador_proyecto', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proyecto_id');
            $table->unsignedBigInteger('perfil_id');

            $table->foreign('proyecto_id')->references('id')->on('proyectos')->onDelete('cascade');
            $table->foreign('perfil_id')->references('id')->on('perfiles')->onDelete('cascade');

            $table->unique(['proyecto_id', 'perfil_id']); // Para evitar duplicados
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('colaborador_proyecto');
    }
};
