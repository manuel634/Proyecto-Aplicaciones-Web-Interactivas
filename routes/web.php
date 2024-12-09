<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AppointmentController; // Importar el controlador de citas
use App\Http\Controllers\PatientController; // Importar el controlador de pacientes
use Illuminate\Support\Facades\Route;

// Ruta predeterminada
Route::get('/', function () {
    return view('welcome');
});

// Ruta de dashboard con autenticación
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas protegidas para perfil de usuario
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Rutas para el CRUD de usuarios (solo para administradores)
    Route::get('admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('admin/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

    // Rutas para citas (pacientes)
    Route::get('appointments', [AppointmentController::class, 'index'])->name('appointments.index');  // Página de citas del paciente
    Route::get('appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');  // Crear cita
    Route::post('appointments', [AppointmentController::class, 'store'])->name('appointments.store');  // Guardar cita

    // Rutas para citas (doctores)
    Route::get('appointments/doctors', [AppointmentController::class, 'doctorIndex'])->name('appointments.doctors.index');  // Página de citas del doctor
    Route::get('appointments/{appointment}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');  // Editar cita (para doctores)
    Route::put('appointments/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update');  // Actualizar cita (para doctores)
    Route::get('appointments/{appointment}/show', [AppointmentController::class, 'show'])->name('appointments.show');  // Ver detalles de cita

    // Rutas para editar el historial médico (doctores)
    Route::get('appointments/{appointment}/edit-medical-history', [AppointmentController::class, 'editMedicalHistory'])->name('appointments.edit_medical_history');  // Ver formulario para editar historial médico
    Route::put('appointments/{appointment}/update-medical-history', [AppointmentController::class, 'updateMedicalHistory'])->name('appointments.update_medical_history');  // Actualizar historial médico

    // Ruta para ver historial médico del paciente autenticado
    Route::get('appointments/medical-history', [AppointmentController::class, 'showMedicalHistory'])->name('appointments.medical_history');
});

// Cargar archivo de autenticación
require __DIR__.'/auth.php';
