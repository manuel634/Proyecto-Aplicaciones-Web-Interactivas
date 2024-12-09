@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Historial Médico de {{ $patient->name }}</h1>

    @if($patient->medical_history)
        <p>{{ $patient->medical_history }}</p>
    @else
        <p>No hay historial médico disponible.</p>
    @endif
</div>
@endsection
