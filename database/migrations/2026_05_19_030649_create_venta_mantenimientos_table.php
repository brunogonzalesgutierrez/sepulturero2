<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('venta_mantenimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mantenimiento_id')->nullable()->constrained('mantenimientos')->nullOnDelete();
            $table->foreignId('espacio_id')->nullable()->constrained('espacios')->nullOnDelete();
            $table->foreignId('tipo_mantenimiento_id')->nullable()->constrained('tipo_mantenimientos')->nullOnDelete();
            $table->foreignId('cliente_id')->constrained('clientes')->restrictOnDelete();
            $table->foreignId('empleado_id')->nullable()->constrained('empleados')->nullOnDelete();
            $table->decimal('precio', 10, 2);
            $table->enum('estado_pago', ['pendiente', 'pagado'])->default('pendiente');
            $table->enum('metodo_pago', ['efectivo', 'transferencia', 'qr', 'online'])->nullable();
            $table->date('fecha_solicitud');
            $table->text('observacion')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('venta_mantenimientos');
    }
};