<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('tareas', function (Blueprint $table) {
            $table->string('estado')->default('pendiente'); // puede ser: pendiente, en_proceso, completada
        });
    }

    public function down()
    {
        Schema::table('tareas', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
    }

};
