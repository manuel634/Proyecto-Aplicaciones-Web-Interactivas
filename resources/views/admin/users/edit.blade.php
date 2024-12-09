@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Usuario</h1>
    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ $user->name }}" required>
        </div>
        <div class="form-group">
            <label for="email">Correo</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>
        <div class="form-group">
            <label for="password">Contraseña (dejar en blanco para no cambiar)</label>
            <input type="password" id="password" name="password" class="form-control">
        </div>
        <div class="form-group">
            <label for="idRol">Rol</label>
            <select id="idRol" name="idRol" class="form-control" required>
                <option value="2" {{ $user->idRol == 2 ? 'selected' : '' }}>Doctor</option>
                <option value="3" {{ $user->idRol == 3 ? 'selected' : '' }}>Paciente</option>
            </select>
        </div>

        @if ($user->idRol == 2) <!-- Solo se muestra para los doctores -->
        <div class="form-group">
            <label for="specialty">Especialidad</label>
            <input type="text" id="specialty" name="specialty" class="form-control" value="{{ $user->specialty }}">
        </div>
        <div class="form-group">
            <label for="license_number">Cédula Profesional</label>
            <input type="text" id="license_number" name="license_number" class="form-control" value="{{ $user->license_number }}">
        </div>
        @elseif ($user->idRol == 3) <!-- Solo se muestra para los pacientes -->
        <div class="form-group">
            <label for="medical_history">Historial Médico</label>
            <textarea id="medical_history" name="medical_history" class="form-control">{{ $user->medical_history }}</textarea>
        </div>
        @endif

        <button type="submit" class="btn btn-success mt-3">Guardar Cambios</button>
    </form>
</div>
@endsection
