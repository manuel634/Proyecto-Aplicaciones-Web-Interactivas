<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    // Definir la tabla asociada al modelo
    protected $table = 'appointments';

    // Definir los campos que son asignables
    protected $fillable = [
        'doctor_id',
        'patient_id',
        'appointment_date',
        'status',
    ];

    // Definir las relaciones
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }
}
