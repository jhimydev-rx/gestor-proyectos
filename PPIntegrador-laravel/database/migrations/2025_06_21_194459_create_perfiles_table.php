<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('perfiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('tipo', ['creador', 'colaborador']);
            $table->string('nombre_perfil')->unique(); // identificador visible
            $table->text('bio')->nullable();
            $table->string('foto')->nullable();
            $table->timestamp('ultimo_cambio_nombre')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perfiles');
    }
};
