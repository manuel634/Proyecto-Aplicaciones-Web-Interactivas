@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Agendar Cita</h1>
    
    <!-- Mostrar errores de validación -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('appointments.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="doctor_id">Seleccionar Doctor</label>
            <select id="doctor_id" name="doctor_id" class="form-control" required>
                @foreach ($doctors as $doctor)
                    <option value="{{ $doctor->id }}">{{ $doctor->name }} - {{ $doctor->specialty ?? 'Sin especialidad' }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label for="appointment_date">Fecha de la Cita</label>
            <input type="datetime-local" id="appointment_date" name="appointment_date" class="form-control" required value="{{ old('appointment_date') }}">
        </div>
        
        <button type="submit" class="btn btn-success mt-3">Agendar Cita</button>
    </form>
</div>
@endsection