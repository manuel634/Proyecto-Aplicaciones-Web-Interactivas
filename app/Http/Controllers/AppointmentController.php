<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    /**
     * Mostrar todas las citas (para administradores)
     */
    public function index()
    {
        $appointments = Appointment::with(['doctor', 'patient'])->get(); // Eager loading para obtener los doctores y pacientes
    
        return view('appointments.index', compact('appointments'));
    }
    
    /**
     * Mostrar el formulario para crear una nueva cita (para pacientes)
     */
    public function create()
    {
        // Solo los pacientes pueden crear citas
        if (Auth::user()->isPatient()) {
            $doctors = User::where('idRol', 2)->get(); // Obtener todos los doctores
            return view('appointments.create', compact('doctors'));
        }

        return redirect()->route('dashboard')->with('error', 'No tienes permiso para agendar citas.');
    }

    /**
     * Almacenar una nueva cita (para pacientes)
     */
    public function store(Request $request)
    {
        // Validación de los datos
        $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date|after:today|date_format:Y-m-d\TH:i', // Validar que la fecha esté en el formato adecuado
        ], [
            'appointment_date.after' => 'La cita debe ser en una fecha futura.',
            'appointment_date.date_format' => 'El formato de la fecha no es válido. Debe ser YYYY-MM-DD HH:MM.',
        ]);

        // Crear y guardar la cita
        $appointment = new Appointment();
        $appointment->patient_id = Auth::id(); // El paciente actual
        $appointment->doctor_id = $request->doctor_id;
        // Asegurarse de que la fecha esté en el formato adecuado
        $appointment->appointment_date = Carbon::parse($request->appointment_date)->format('Y-m-d H:i:s');
        $appointment->status = 'pending'; // Estado inicial de la cita
        $appointment->save();

        return redirect()->route('appointments.index')->with('success', 'Cita agendada exitosamente.');
    }

    /**
     * Mostrar el formulario para editar una cita (para doctores)
     */
    public function edit($id)
    {
        $appointment = Appointment::findOrFail($id);

        // Verificar que el usuario sea el doctor asignado a la cita
        if (Auth::user()->id === $appointment->doctor_id) {
            return view('appointments.doctors.edit', compact('appointment')); // Cambié a 'appointments.doctors.edit'
        }

        return redirect()->route('dashboard')->with('error', 'No tienes permiso para editar esta cita.');
    }

    /**
     * Actualizar una cita (para doctores)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled', // Los posibles estados de la cita
        ]);

        $appointment = Appointment::findOrFail($id);

        // Verificar que el usuario sea el doctor asignado a la cita
        if (Auth::user()->id !== $appointment->doctor_id) {
            return redirect()->route('dashboard')->with('error', 'No tienes permiso para editar esta cita.');
        }

        $appointment->status = $request->status; // Actualizamos el estado
        $appointment->save();

        return redirect()->route('appointments.index')->with('success', 'Cita actualizada exitosamente.');
    }

    /**
     * Eliminar una cita
     */
    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);

        // Verificar que el usuario sea el paciente o doctor asignado a la cita
        if (Auth::user()->id !== $appointment->patient_id && Auth::user()->id !== $appointment->doctor_id) {
            return redirect()->route('dashboard')->with('error', 'No tienes permiso para eliminar esta cita.');
        }

        $appointment->delete();

        return redirect()->route('appointments.index')->with('success', 'Cita eliminada exitosamente.');
    }

    /**
     * Mostrar las citas asignadas al doctor (para doctores)
     */
    public function doctorIndex()
    {
        // Obtener todas las citas asignadas al doctor autenticado
        $appointments = Appointment::where('doctor_id', Auth::id())
            ->with(['patient'])
            ->paginate(10); // Paginación de 10 citas por página

        // Retornar la vista de citas del doctor en la carpeta correcta
        return view('appointments.doctors.index', compact('appointments'));
    }

    /**
     * Editar el historial médico de un paciente (para doctores)
     */
    public function editMedicalHistory($id)
    {
        $appointment = Appointment::findOrFail($id);

        // Verificar que el usuario sea el doctor asignado a la cita
        if (Auth::user()->id !== $appointment->doctor_id) {
            return redirect()->route('dashboard')->with('error', 'No tienes permiso para editar el historial médico de este paciente.');
        }

        // Recuperar el paciente de la cita
        $patient = $appointment->patient;

        return view('appointments.doctors.edit_medical_history', compact('appointment', 'patient'));
    }

    /**
     * Actualizar el historial médico de un paciente (para doctores)
     */
    public function updateMedicalHistory(Request $request, $id)
    {
        $request->validate([
            'medical_history' => 'required|string|max:1000', // Validar el historial médico
        ]);

        $appointment = Appointment::findOrFail($id);

        // Verificar que el usuario sea el doctor asignado a la cita
        if (Auth::user()->id !== $appointment->doctor_id) {
            return redirect()->route('dashboard')->with('error', 'No tienes permiso para actualizar el historial médico de este paciente.');
        }

        // Actualizar el historial médico del paciente
        $patient = $appointment->patient;
        $patient->medical_history = $request->medical_history;
        $patient->save();

        return redirect()->route('appointments.doctors.index')->with('success', 'Historial médico actualizado exitosamente.');
    }

    /**
     * Mostrar el historial médico del paciente autenticado
     */
    public function showMedicalHistory()
    {
        // Obtener el paciente autenticado
        $patient = Auth::user(); // Usamos el paciente autenticado

        // Verificar si el paciente tiene historial médico
        if (!$patient->medical_history) {
            return redirect()->route('appointments.index')->with('error', 'No tienes historial médico registrado.');
        }

        return view('appointments.medical_history', compact('patient'));
    }
}
