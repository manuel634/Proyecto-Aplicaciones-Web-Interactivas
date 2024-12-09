<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',            // Nombre del usuario
        'email',           // Correo electrónico
        'password',        // Contraseña
        'phone',           // Teléfono
        'idRol',           // Rol del usuario (1: Admin, 2: Doctor, 3: Paciente)
        'medical_history', // Historial médico (pacientes)
        'license_number',  // Cédula profesional (doctores)
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Determine if the user is an admin.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->idRol === 1;
    }

    /**
     * Determine if the user is a doctor.
     *
     * @return bool
     */
    public function isDoctor(): bool
    {
        return $this->idRol === 2;
    }

    /**
     * Determine if the user is a patient.
     *
     * @return bool
     */
    public function isPatient(): bool
    {
        return $this->idRol === 3;
    }

    // Relación de un doctor con sus citas
    public function appointmentsAsDoctor()
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }

    // Relación de un paciente con sus citas
    public function appointmentsAsPatient()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }
}
