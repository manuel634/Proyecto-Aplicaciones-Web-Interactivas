@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Mis Citas</h1>
    
    @if ($appointments->isEmpty())
        <p>No tienes citas agendadas.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Doctor</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->doctor->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y H:i') }}</td>
                        <td>
                            @if ($appointment->status === 'pending')
                                <button class="btn btn-warning">Esperando confirmación</button>
                            @else
                                <button class="btn btn-secondary" disabled>Confirmada</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="d-flex">
        <!-- Botón Agendar Nueva Cita con margen derecho -->
        <a href="{{ route('appointments.create') }}" class="btn btn-primary" style="margin-right: 5px;">Agendar Nueva Cita</a>
        
        <!-- Botón Ver Mi Historial Médico con margen izquierdo -->
        <a href="{{ route('appointments.medical_history') }}" class="btn btn-info" style="margin-left: 5px;">Ver Mi Historial Médico</a>
    </div>
</div>
@endsection






