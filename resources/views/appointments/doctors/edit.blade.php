@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Confirmar Cita</h1>

    <form action="{{ route('appointments.update', $appointment->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="status">Estado de la Cita</label>
            <select name="status" id="status" class="form-control" required>
                <option value="pending" {{ $appointment->status === 'pending' ? 'selected' : '' }}>Pendiente</option>
                <option value="confirmed" {{ $appointment->status === 'confirmed' ? 'selected' : '' }}>Confirmada</option>
                <option value="cancelled" {{ $appointment->status === 'cancelled' ? 'selected' : '' }}>Cancelada</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success mt-3">Actualizar Estado</button>
    </form>
</div>
@endsection
