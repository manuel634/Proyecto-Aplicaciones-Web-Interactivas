@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Citas Pendientes</h1>
    
    @if ($appointments->isEmpty())
        <p>No tienes citas pendientes.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Paciente</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->patient->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y H:i') }}</td>
                        <td>{{ ucfirst($appointment->status) }}</td>
                        <td>
                            @if ($appointment->status === 'pending')
                                <a href="{{ route('appointments.edit', $appointment->id) }}" class="btn btn-primary">Confirmar</a>
                            @else
                                <button class="btn btn-secondary" disabled>Confirmada</button>
                            @endif
                            
                            <!-- Botón para modificar el historial médico -->
                            <a href="{{ route('appointments.edit_medical_history', $appointment->id) }}" class="btn btn-warning">Modificar Historial Médico</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Paginación -->
        <div class="d-flex justify-content-center">
            {{ $appointments->links() }}
        </div>
    @endif
</div>
@endsection
