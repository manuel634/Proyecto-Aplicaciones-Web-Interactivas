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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique(); // Correo único
            $table->string('password'); // Contraseña
            $table->string('name'); // Nombre del usuario
            $table->string('phone')->nullable(); // Teléfono (opcional)
            $table->integer('idRol'); // 1: Administrador, 2: Doctor, 3: Paciente
            $table->text('medical_history')->nullable(); // Historial médico (solo pacientes)
            $table->string('license_number')->nullable(); // Cédula profesional (solo doctores)
            $table->timestamps(); // Campos de created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
