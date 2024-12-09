<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    /**
     * Mostrar el historial médico de un paciente.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function showMedicalHistory($id)
    {
        // Obtener al paciente por su ID
        $patient = User::findOrFail($id);

        // Verificar que el usuario autenticado sea el mismo que el paciente
        if (Auth::user()->id !== $patient->id) {
            return redirect()->route('dashboard')->with('error', 'No tienes permiso para ver este historial médico.');
        }

        // Devolver la vista con el historial médico del paciente
        return view('patients.medical_history', compact('patient'));
    }
}
