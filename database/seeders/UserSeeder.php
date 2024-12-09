<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Contraseña única para todos los usuarios de prueba
        $password = Hash::make('12345678');

        // Administrador
        User::create([
            'email' => 'admin@example.com',
            'password' => $password, // Contraseña encriptada
            'name' => 'Admin User',
            'idRol' => 1, // Rol de administrador
        ]);

        // Doctor
        User::create([
            'email' => 'doctor@example.com',
            'password' => $password, // Contraseña encriptada
            'name' => 'Doctor User',
            'phone' => '1234567890',
            'idRol' => 2, // Rol de doctor
            'license_number' => 'DOC12345', // Cédula profesional
        ]);

        // Paciente
        User::create([
            'email' => 'patient@example.com',
            'password' => $password, // Contraseña encriptada
            'name' => 'Patient User',
            'phone' => '0987654321',
            'idRol' => 3, // Rol de paciente
            'medical_history' => 'Sin alergias conocidas.', // Historial médico
        ]);
    }
}
