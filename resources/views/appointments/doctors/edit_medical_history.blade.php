@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Historial Médico de {{ $patient->name }}</h1>

    <form action="{{ route('appointments.update_medical_history', $appointment->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="medical_history">Historial Médico:</label>
            <textarea id="medical_history" name="medical_history" class="form-control" rows="5">{{ $patient->medical_history }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Guardar Cambios</button>
    </form>
</div>
@endsection
