<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tipo_inhumaciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->decimal('precio', 10, 2);      // precio fijo de inhumación
            $table->decimal('precio_m2', 10, 2);   // precio por m² del tipo (antes precio_base)
            $table->integer('capacidad_max');
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            $table->decimal('area_base', 8, 2);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tipo_inhumaciones');
    }
};