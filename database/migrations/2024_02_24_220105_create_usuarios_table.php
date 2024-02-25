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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150);
            $table->string('correo', 150);
            $table->string('cedula', 30);
            $table->date('fecha_nacimiento');
            $table->unsignedBigInteger('cargo_id'); // Clave foránea
            $table->timestamps();
            $table->foreign('cargo_id')->references('id')->on('cargos'); // Definición de la clave foránea
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
