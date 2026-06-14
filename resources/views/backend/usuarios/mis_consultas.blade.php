@extends('plantilla')
@section('contenido')

<div class="container my-5 text-white">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 style="color: #77c040;">Historial de mis Consultas</h2>
        <a href="{{ route('cliente') }}" class="btn btn-sm btn-outline-secondary">Volver a Mi Cuenta</a>
    </div>

    <div class="row g-3">
        @forelse($consultas as $consulta)
            <div class="col-12 bg-dark p-3 rounded border border-secondary">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="text-secondary small">{{ $consulta->created_at->format('d/m/Y H:i') }}</span>
                    @if($consulta->respuesta)
                        <span class="badge bg-success text-dark">Respondido</span>
                    @else
                        <span class="badge bg-warning text-dark">Pendiente de respuesta</span>
                    @endif
                </div>
                
                <p class="mb-2"><strong>Mi consulta:</strong> {{ $consulta->mensaje }}</p>

                @if($consulta->respuesta)
                    <div class="p-2 mt-2 rounded border border-success" style="background-color: rgba(119, 192, 64, 0.05)">
                        <strong class="text-success">Respuesta del administrador:</strong>
                        <p class="mb-0 text-light mt-1">{{ $consulta->respuesta }}</p>
                    </div>
                @endif
            </div>
        @empty
            <div class="col-12 text-center text-muted py-5 bg-dark rounded border border-secondary">
                <i class="bi bi-chat-left-text d-block mb-2" style="font-size: 2rem;"></i>
                Aún no has realizado ninguna consulta a través del formulario de contacto.
            </div>
        @endforelse
    </div>
</div>

@endsection