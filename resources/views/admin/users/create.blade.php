@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Nuevo Usuario</h1>
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Correo</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="idRol">Rol</label>
            <select id="idRol" name="idRol" class="form-control" required>
                <option value="2">Doctor</option>
                <option value="3">Paciente</option>
            </select>
        </div>

        <!-- Campo para especialidad, solo visible para doctores -->
        <div class="form-group" id="specialty_field" style="display: none;">
            <label for="specialty">Especialidad</label>
            <input type="text" id="specialty" name="specialty" class="form-control">
        </div>

        <!-- Campo para cédula profesional, solo visible para doctores -->
        <div class="form-group" id="license_number_field" style="display: none;">
            <label for="license_number">Cédula Profesional</label>
            <input type="text" id="license_number" name="license_number" class="form-control">
        </div>

        <!-- Campo para historial médico, solo visible para pacientes -->
        <div class="form-group" id="medical_history_field" style="display: none;">
            <label for="medical_history">Historial Médico</label>
            <textarea id="medical_history" name="medical_history" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-success mt-3">Guardar Usuario</button>
    </form>
</div>

<script>
    document.getElementById('idRol').addEventListener('change', function() {
        var specialtyField = document.getElementById('specialty_field');
        var licenseField = document.getElementById('license_number_field');
        var medicalField = document.getElementById('medical_history_field');
        
        // Mostrar/ocultar campos según el rol seleccionado
        if (this.value == 2) {  // Si es Doctor
            specialtyField.style.display = 'block';  // Mostrar campo de especialidad
            licenseField.style.display = 'block';   // Mostrar campo de cédula profesional
            medicalField.style.display = 'none';    // Ocultar campo de historial médico
        } else if (this.value == 3) {  // Si es Paciente
            specialtyField.style.display = 'none';  // Ocultar campo de especialidad
            licenseField.style.display = 'none';   // Ocultar campo de cédula profesional
            medicalField.style.display = 'block';  // Mostrar campo de historial médico
        }
    });
</script>
@endsection
